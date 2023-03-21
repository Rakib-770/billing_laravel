<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientInfo;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use App\Models\InvoiceFor;


class InvoiceDetailsMcloudController extends Controller
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

    public function invoiceDetailsMcloud(Request $request)
    {
        $data = InvoiceFor::all();

        $inv_month_year = $request->InvMonthYear;
        $client_name = $request->clientName;
        $invoice_details_for = $request->invoice_for;

        $showInvoice = DB::table('invoices')
            ->where('invoices.invoice_month_year', $inv_month_year)
            ->where('invoices.invoice_for', $invoice_details_for)
            ->groupBy('invoices.invoice_month_year')
            ->get();

        return view('invoice-details-mcloud', compact('data', 'showInvoice'));
    }

    // public function pdfInvoiceDetails($id)
    // {
    //     $pdf_invoice_details = DB::table('invoices')
    //         ->join('client_infos', 'invoices.client_id', "=", 'client_infos.id')
    //         ->join('bill_details', 'client_infos.id', '=', 'bill_details.client_id')
    //         ->select('invoices.*', 'invoices.id as invID', 'client_infos.*', 'bill_details.*')
    //         ->where(DB::raw("CONCAT(invoices.invoice_month_year, invoices.invoice_for)"), '=', $id)
    //         ->groupBy('invoices.client_id')
    //         ->get();
    //     $final_arr = array();

    //     foreach ($pdf_invoice_details as $key => $value) {
    //         $services = DB::table('bill_details as cbi')
    //             ->leftJoin('service_infos as si', 'si.id', 'cbi.service_id')
    //             ->select('cbi.*', 'si.*', 'cbi.id as cbiID', DB::raw('sum(quantity) as squantity'))
    //             ->where('cbi.client_id', $value->client_id)
    //             ->groupBy('si.id')
    //             ->get();

    //         $temp['invoice_info'] = $pdf_invoice_details[$key];
    //         $temp['services'] = $services;
    //         array_push($final_arr, $temp);
    //     }
    //     $dompdf = new Dompdf();
    //     $dompdf->loadHtml(view('pdf-invoice-details', compact('final_arr')));
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();
    //     $dompdf->stream("pdf", ['Attachment' => false]);
    // }

    public function pdfInvoiceDetails($id)
    {
        $pdf_invoice_details = DB::table('invoices')
            ->join('client_infos', 'invoices.client_id', "=", 'client_infos.id')
            ->join('client_bill_infos', 'client_infos.id', '=', 'client_bill_infos.client_id')
            ->select('invoices.*', 'invoices.id as invID', 'client_infos.*', 'client_bill_infos.*')
            ->where(DB::raw("CONCAT(invoices.invoice_month_year, invoices.invoice_for)"), '=', $id)
            ->groupBy('invoices.client_id')
            ->get();

        $final_arr = array();

        foreach ($pdf_invoice_details as $key => $value) {
            $services = DB::table('client_bill_infos as cbi')
                ->leftJoin('service_infos as si', 'si.id', 'cbi.service_id')
                ->select('cbi.*', 'si.*', 'cbi.id as cbiID')
                ->where('cbi.client_id', $value->client_id)
                ->groupBy('si.id')
                ->get();

            foreach ($services as $key => $item) {
                $pServices = DB::table('bill_details as bd')
                ->leftJoin('service_infos as si', 'si.id', 'bd.service_id')
                ->select('bd.*', 'si.*')
                ->where('bd.client_id', $item->client_id)
                ->get();
            }

            $temp['invoice_info'] = $pdf_invoice_details[$key];
            $temp['services'] = $services;
            array_push($final_arr, $temp);
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdf-invoice-details', compact('final_arr')));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("pdf", ['Attachment' => false]);
    }
}
