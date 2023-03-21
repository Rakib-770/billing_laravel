<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdhocInvoiceGenerationController extends Controller
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

    public function adhocInvoiceGeneration()
    {
        $data['invoice_for'] = DB::table('invoice_fors')
            ->get();
        return view('adhoc-invoice-generation', $data);
    }

    public function getClient(Request $request)
    {
        $InvForID = $request->post('InvForID');
        $clientData = DB::table('client_infos')
            ->where('invoice_for', $InvForID)
            ->orderBy('client_name', 'asc')
            ->get();

        $html = '<option value="">--select client name--</option>';
        foreach ($clientData as $list) {
            // $html .= '<option value="' . $list->id . '">' . $list->client_name . '</option>';
            $html .= '<option value="' . $list->id . '">' . $list->client_name . " ID:" . $list->id . '</option>';
        }
        echo $html;
    }

    public function storeAdhocInvoice(Request $request)
    {
        $rules = [
            'invoice_for' => 'required',
            'invoice_month_year' => 'required',
            'invoice_date' => 'required',
            'invoice_from_date' => 'required',
            'invoice_to_date' => 'required',
            'invoice_due_date' => 'required',
        ];
        $cm = [
            'invoice_for.required' => 'Select invoice for',
            'invoice_month_year.required' => 'Select invoice month year',
            'invoice_date.required' => 'Select invoice date',
            'invoice_from_date.required' => 'Select invoice from date',
            'invoice_to_date.required' => 'Select invoice to date',
            'invoice_due_date.required' => 'Select invoice due date',
        ];
        $this->validate($request, $rules, $cm);

        $client_id = $request->client_name;
        $invFrom = $request->invoice_from_date;
        $invTo = $request->invoice_to_date;

        $totalMonthlyDays = strtotime($invTo) - strtotime($invFrom);

        $AdhocInvQuery = DB::table('client_infos')
            ->select(
                'client_infos.id',
                'client_infos.client_name',
                'client_infos.client_vat',
                'client_infos.status',
                'client_infos.invoice_type',
                'client_bill_infos.client_id',
                'client_bill_infos.status',
                'client_bill_infos.available_from',
                'client_bill_infos.available_till',
                'client_bill_infos.quantity',
                'client_bill_infos.unit_price',
                'client_bill_infos.service_id',
                DB::raw('(client_bill_infos.quantity * client_bill_infos.unit_price) as all_quantity_total'),
            )
            ->join('client_bill_infos', 'client_bill_infos.client_id', '=', 'client_infos.id')
            ->where('client_bill_infos.status', 'y')
            ->where('client_infos.id', $client_id)
            ->groupBy('client_bill_infos.id')
            ->get();

        $last_inv_id = DB::table('invoice_masters')
            ->select('invoice_id')
            ->orderBy('invoice_id', 'DESC')
            ->first();
        if ($last_inv_id !== null) {
            $invMasterArr['invoice_id'] = $last_inv_id->invoice_id + 1;
        } else {
            $invMasterArr['invoice_id'] = 1;
        }

        foreach ($AdhocInvQuery as $key => $value) {

            $last_inv_master_id = DB::table('invoice_masters')
                ->select('id')
                ->orderBy('id', 'DESC')
                ->first();
            if ($last_inv_master_id !== null) {
                $invMasterArr['id'] = $last_inv_master_id->id + 1;
            } else {
                $invMasterArr['id'] = 1;
            }

            $invMasterArr['client_id'] = $value->client_id;
            $invMasterArr['service_id'] = $value->service_id;

            if ($value->available_from <= $invFrom && $value->available_till >= $invTo) {
                $invMasterArr['sub_total'] = $value->all_quantity_total;
            } elseif ($value->available_from >= $invFrom && $value->available_till <= $invTo) {
                $availableTill = $value->available_till;
                $availableFrom = $value->available_from;
                $splitDays = strtotime($availableTill) - strtotime($availableFrom); // split Days
                $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1); // convert total monthly days
                $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                $allQuantityTotal = $value->all_quantity_total; // service total
                $thisMonthPerDay = $allQuantityTotal / $convertMonthlyDays; // per day amount
                $thisMonthTotal = $thisMonthPerDay * $convertSplitDays; // this month total (per day * split days)
                $invMasterArr['sub_total'] = $thisMonthTotal; // store sub_total (quantity * unit_price)
            } elseif ($value->available_till < $invFrom) {
                $invMasterArr['sub_total'] = 0;
            } elseif ($value->available_from > $invFrom) {
                $availableFrom = $value->available_from;
                $splitDays = strtotime($invTo) - strtotime($availableFrom); // split Days
                $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1);  // convert total monthly days
                $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                $allQuantityTotal = $value->all_quantity_total; // service total
                $thisMonthPerDay = $allQuantityTotal / $convertMonthlyDays; // per day amount
                $thisMonthTotal = $thisMonthPerDay * $convertSplitDays; // this month total (per day * split days)
                $invMasterArr['sub_total'] = $thisMonthTotal; // store sub_total (quantity * unit_price)
            } elseif ($value->available_till < $invTo) {
                $availableTill = $value->available_till;
                $splitDays = strtotime($availableTill) - strtotime($invFrom); // split Days
                $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1);  // convert total monthly days
                $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                $allQuantityTotal = $value->all_quantity_total; // service total
                $thisMonthPerDay = $allQuantityTotal / $convertMonthlyDays; // per day amount
                $thisMonthTotal = $thisMonthPerDay * $convertSplitDays; // this month total (per day * split days)
                $invMasterArr['sub_total'] = $thisMonthTotal; // store sub_total (quantity * unit_price)
            }

            $invMasterArr['created_at'] =  Carbon::now();
            $invMasterArr['updated_at'] =  now();

            DB::table('invoice_masters')->insert($invMasterArr);
        }

        $last_inv_id = DB::table('invoice_masters')
            ->select('invoice_id')
            ->orderBy('invoice_id', 'DESC')
            ->first();
        $var = $last_inv_id->invoice_id;

        $AdhocInvSecondQuery = DB::table('client_infos')
            ->select(
                'client_infos.id',
                'client_infos.client_name',
                'client_infos.client_vat',
                'client_infos.status',
                'client_infos.invoice_type',
                'invoice_masters.invoice_id',
                DB::raw('SUM(sub_total) as all_service_total'),
            )
            ->join('invoice_masters', 'invoice_masters.client_id', '=', 'client_infos.id')
            ->where('client_infos.id', $client_id)
            ->where('invoice_masters.invoice_id', $var)
            ->groupBy('client_infos.id')
            ->get();

        $last_batch_number = DB::table('invoices')
            ->select('batch_number')
            ->orderBy('batch_number', 'DESC')
            ->first();

        if ($last_batch_number !== null) {
            $invArr['batch_number'] = $last_batch_number->batch_number + 1;
        } else {
            $invArr['batch_number'] = 1;
        }

        foreach ($AdhocInvSecondQuery as $key => $value) {

            $last_inv_id = DB::table('invoice_masters')
                ->select('invoice_id')
                ->orderBy('invoice_id', 'DESC')
                ->first();

            $invArr['id'] = $value->invoice_id;
            $invArr['client_id'] = $value->id;
            $invArr['invoice_for'] = $request->invoice_for;
            $invArr['invoice_type'] = $value->invoice_type;
            $invArr['invoice_month_year'] = $request->invoice_month_year;
            $invArr['invoice_date'] = $request->invoice_date;
            $invArr['invoice_from_date'] = $request->invoice_from_date;
            $invArr['invoice_to_date'] = $request->invoice_to_date;
            $invArr['invoice_due_date'] = $request->invoice_due_date;
            $invArr['sub_total'] = $value->all_service_total;
            $invArr['client_vat'] = $value->client_vat;

            if ($request->arrear_title != null && $request->arrear_amount != null) {
                $last_arrear_id = DB::table('arrears')
                ->select('id')
                ->orderBy('id', 'DESC')
                ->first();
                if ($last_arrear_id !== null) {
                    $arrearArr['id'] = $last_arrear_id->id + 1;
                } else {
                    $arrearArr['id'] = 1;
                }
                $arrearArr['inv_id'] = $value->invoice_id;
                $arrearArr['title'] = $request->arrear_title;
                $arrearArr['amount'] = $request->arrear_amount;
                $arrearArr['created_at'] =  Carbon::now();
                $arrearArr['updated_at'] =  now();
                DB::table('arrears')->insert($arrearArr);

                $invArr['total_amount'] = ($invArr['sub_total'] + $arrearArr['amount']) + (($invArr['client_vat'] / 100) * ($invArr['sub_total'] + $arrearArr['amount']));
                
            }
            else{
                $invArr['total_amount'] = $invArr['sub_total'] + (($invArr['client_vat'] / 100) * $invArr['sub_total']);
            }
            
            $invArr['invoice_generated_by'] =  Auth::user()->name;
            $invArr['created_at'] =  Carbon::now();
            $invArr['updated_at'] =  now();
            DB::table('invoices')->insert($invArr);

            DB::table('client_infos')
                ->where('id', $value->id)
                ->update(['mrc_tk' => $invArr['sub_total'] + (($invArr['client_vat'] / 100) * $invArr['sub_total'])]);
        }
        Session::flash('msg', 'Adhoc Invoice successfully Generated.');
        return redirect()->back();
    }
}
