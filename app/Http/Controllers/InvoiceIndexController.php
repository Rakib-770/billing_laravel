<?php

namespace App\Http\Controllers;

use App\Models\Arrears;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class InvoiceIndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Invoice Index page

    public function invoiceIndex(Request $request)
    {
        $from_date = $request->fromDate;
        $to_date = $request->toDate;
        $inv_for = $request->invFor;
        $showInvoice = DB::table('invoices')
            ->select('batch_number', 'invoice_for', 'invoice_type', 'invoice_date', 'invoice_month_year', 'invoice_generated_by')
            ->whereBetween('invoice_date', [$from_date, $to_date])
            ->where('invoice_for', $inv_for)
            ->groupBy('batch_number')
            ->orderBy('id', 'DESC')
            ->get();

        $invFor = DB::table('invoice_fors')->get();
        return view('invoice-index', compact('showInvoice', 'invFor'));
    }

    // Generate The PDF file of Invoice 
    public function pdfInvoice($id = null)
    {
        $pdf_invoice = DB::table('invoices')
            ->join('client_bill_infos', 'invoices.client_id', "=", 'client_bill_infos.client_id')
            ->join('client_infos', 'client_bill_infos.client_id', "=", 'client_infos.id')
            ->leftjoin('arrears', 'arrears.inv_id', '=', 'invoices.id')
            ->select(
                'client_infos.id as client_id',
                'client_infos.client_name',
                'client_infos.client_address',
                'client_infos.invoice_contact_person',
                'client_infos.contact_person_designation',
                'client_infos.contact_person_phone',
                'client_infos.contact_person_email',
                'client_infos.client_bin_number',
                'client_infos.client_po_number',
                'client_infos.client_vat',
                'client_infos.service_location',
                'client_infos.invoice_for',

                'invoices.id as in_id',
                'invoices.invoice_date',
                'invoices.invoice_month_year',
                'invoices.invoice_due_date',
                'invoices.invoice_from_date',
                'invoices.invoice_to_date',
                'invoices.sub_total',
                'invoices.total_amount',

                'invoices.created_at as iat',

                'arrears.title as arrearsTitle',
                'arrears.amount as arrearsAmount',
            )

            ->where('invoices.batch_number', $id)
            ->groupBy('invoices.client_id')
            ->get();

        $final_arr = array();
        foreach ($pdf_invoice as $key => $value) {

            $services = DB::table('client_bill_infos as cbi')
                ->select(
                    'cbi.created_at as cat',
                    'cbi.updated_at as uat',
                    'cbi.status',
                    'cbi.quantity',
                    'cbi.unit_price',
                    DB::raw('cbi.unit_price * cbi.quantity as cbiTotal'),
                    'cbi.available_from',
                    'cbi.available_till',

                    'si.service_name'
                )
                ->leftJoin('service_infos as si', 'si.id', 'cbi.service_id')
                ->where('cbi.client_id', $value->client_id)
                ->orderBy('cbiTotal', 'desc')
                ->get();

            $pdfName = $value->invoice_month_year;
            $temp['invoice_info'] = $pdf_invoice[$key];
            $temp['services'] = $services;
            array_push($final_arr, $temp);
        }
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdf-invoice', compact('final_arr')));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($pdfName, ['Attachment' => false]);
        
    }

    public function batchInvoiceDetails($id = null)
    {
        $batch_invoice_details = DB::table('invoices')
            ->join('client_infos', 'invoices.client_id', '=', 'client_infos.id')
            ->where('invoices.batch_number', $id)
            ->select('invoices.*', 'client_infos.client_name')
            ->groupBy('invoices.client_id')
            ->get();

        $invForValue = DB::table('invoices')
            ->where('invoices.batch_number', $id)
            ->select('invoices.invoice_for')
            ->groupBy('batch_number')
            ->value('invoice_for');

        $invTypeValue = DB::table('invoices')
            ->where('invoices.batch_number', $id)
            ->select('invoices.invoice_type')
            ->groupBy('batch_number')
            ->value('invoice_type');

        $last_batch_number = DB::table('invoices')
            ->where('invoice_for', $invForValue)
            ->where('invoice_type', $invTypeValue)
            // ->groupBy('batch_number')
            ->max('batch_number');

        $clients_in_batch = DB::table('invoices')
            ->where('invoices.batch_number', $id)
            ->select('client_id')
            ->groupBy('client_id')
            ->get();
        $client_count = $clients_in_batch->count();

        // echo ($value_count);
        // exit();

        return view('batch-invoice-details', compact('batch_invoice_details', 'last_batch_number', 'client_count'));
    }

    public function deleteInv($id = null)
    {
        $inv_client_id = DB::table('invoices')
            ->where('id', $id)
            ->select('client_id')
            ->value('client_id');
        $client_wise_last_inv_id = DB::table('invoices')
            ->where('client_id',  $inv_client_id)
            ->select('id')
            ->orderBy('id', 'desc')
            ->value('id');

        if ($client_wise_last_inv_id == $id) {
            $deleteInv = DB::table('invoices')
                ->where('id', $id)
                ->delete();
            $deleteInvMaster = DB::table('invoice_masters')
                ->where('invoice_id', $id)
                ->delete();
            $deleteArrear = DB::table('arrears')
                ->where('inv_id', $id)
                ->delete();

            Session::flash('msg', 'Invoice successfully Deleted');
            return redirect()->back()->with(compact('deleteInv', 'deleteInvMaster'));
        }

        else{
            Session::flash('msg2', 'This invoice can not be deleted');
            return redirect()->back();
        }
    }

    public function deleteCheckedInvoice(Request $request)
    {
        $ids = $request->ids;
        Invoice::whereIn('id', $ids)->delete();
        InvoiceMaster::whereIn('invoice_id', $ids)->delete();
        Arrears::whereIn('inv_id', $ids)->delete();
        return response()->json(['success' => "Invoice deleted"]);
    }

    public static function getBangladeshCurrency($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lac', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Taka = implode('', array_reverse($str));
        $poysa = ($decimal) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' paisa' : '';
        return ($Taka ? $Taka . 'taka ' : '') . $poysa;
    }
}
