<?php

namespace App\Http\Controllers;

use App\Models\InvoiceFor;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class InvoiceGenerationController extends Controller
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

    // View Invoice Generation 

    public function invoiceGeneration()
    {
        $data = InvoiceFor::all();
        return view('invoice-generation', ['data' => $data]);
    }

    public function storeInvoice(Request $request)
    {
        $rules = [
            'invoice_for' => 'required',
            'invoice_type' => 'required',
            'invoice_month_year' => 'required',
            'invoice_date' => 'required',
            'invoice_from_date' => 'required',
            'invoice_to_date' => 'required',
            'invoice_due_date' => 'required',
        ];
        $cm = [
            'invoice_for.required' => 'Select invoice for',
            'invoice_type.required' => 'Select invoice type',
            'invoice_month_year.required' => 'Select invoice month year',
            'invoice_date.required' => 'Select invoice date',
            'invoice_from_date.required' => 'Select invoice from date',
            'invoice_to_date.required' => 'Select invoice to date',
            'invoice_due_date.required' => 'Select invoice due date',
        ];
        $this->validate($request, $rules, $cm);
        $invoice_for = $request->invoice_for;
        $invoice_type = $request->invoice_type;
        $invQuery = DB::table('client_infos')
            ->select(
                'client_infos.id',
                'client_infos.client_name',
                'client_infos.client_vat',
                'client_infos.status',
                'client_bill_infos.status',
                'client_bill_infos.available_from',
                'client_bill_infos.available_till',
                DB::raw('SUM(client_bill_infos.quantity * client_bill_infos.unit_price) as all_service_total')
            )
            ->join('client_bill_infos', 'client_bill_infos.client_id', '=', 'client_infos.id')
            ->where('client_infos.status', 'y')
            ->where('client_bill_infos.status', 'y')
            ->where('client_infos.invoice_for', $invoice_for)
            ->where('client_infos.invoice_type', $invoice_type)
            ->groupBy('client_infos.id')
            ->get();

        // CALCULATE BATCH NUMBER

        $last_batch_number = DB::table('invoices')
            ->select('batch_number')
            ->orderBy('batch_number', 'DESC')
            ->first();
        if ($last_batch_number !== null) {
            $invArr['batch_number'] = $last_batch_number->batch_number + 1;
        } else {
            $invArr['batch_number'] = 1;
        }
        foreach ($invQuery as $key => $value) {

            // CALCULATE INVOICE ID

            $last_inv_id = DB::table('invoices')
                ->select('id')
                ->orderBy('id', 'DESC')
                ->first();
            if ($last_inv_id !== null) {
                $invArr['id'] = $last_inv_id->id + 1;
            } else {
                $invArr['id'] = 1;
            }
            $invArr['client_id'] = $value->id;
            $invArr['invoice_for'] = $request->invoice_for;
            $invArr['invoice_type'] = $request->invoice_type;
            $invArr['invoice_month_year'] = $request->invoice_month_year;
            $invArr['invoice_date'] = $request->invoice_date;
            $invArr['invoice_from_date'] = $request->invoice_from_date;
            $invArr['invoice_to_date'] = $request->invoice_to_date;
            $invArr['invoice_due_date'] = $request->invoice_due_date;
            $invArr['sub_total'] = 0;
            $invArr['client_vat'] = $value->client_vat;
            $invArr['total_amount'] = 0;
            $invArr['invoice_generated_by'] =  Auth::user()->name;
            $invArr['created_at'] =  Carbon::now();
            $invArr['updated_at'] =  now();
            DB::table('invoices')->insert($invArr);

            $invMasterQuery = DB::table('client_infos')
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
                ->where('client_infos.status', 'y')
                ->where('client_bill_infos.status', 'y')
                ->where('client_infos.id', $value->id)
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
            $invFrom = $request->invoice_from_date;
            $invTo = $request->invoice_to_date;
            $totalMonthlyDays = strtotime($invTo) - strtotime($invFrom);

            foreach ($invMasterQuery as $key => $invMasterData) {
                $last_inv_master_id = DB::table('invoice_masters')
                    ->select('id')
                    ->orderBy('id', 'DESC')
                    ->first();
                if ($last_inv_master_id !== null) {
                    $invMasterArr['id'] = $last_inv_master_id->id + 1;
                } else {
                    $invMasterArr['id'] = 1;
                }

                $invMasterArr['client_id'] = $value->id;
                $invMasterArr['service_id'] = $invMasterData->service_id;


                if ($invMasterData->available_from <= $invFrom && $invMasterData->available_till >= $invTo) {
                    $invMasterArr['sub_total'] = $invMasterData->all_quantity_total;
                } elseif ($invMasterData->available_from >= $invFrom && $invMasterData->available_till <= $invTo) {
                    $availableTill = $invMasterData->available_till;
                    $availableFrom = $invMasterData->available_from;
                    $splitDays = strtotime($availableTill) - strtotime($availableFrom); // split Days
                    $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1); // convert total monthly days
                    $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                    $allQuantityTotal = $invMasterData->all_quantity_total; // service total
                    $thisMonthPerDay = $allQuantityTotal / $convertMonthlyDays; // per day amount
                    $thisMonthTotal = $thisMonthPerDay * $convertSplitDays; // this month total (per day * split days)
                    $invMasterArr['sub_total'] = $thisMonthTotal; // store sub_total (quantity * unit_price)
                } elseif ($invMasterData->available_till < $invFrom) {
                    $invMasterArr['sub_total'] = 0;
                } elseif ($invMasterData->available_from > $invFrom) {
                    $availableFrom = $invMasterData->available_from;
                    $splitDays = strtotime($invTo) - strtotime($availableFrom); // split Days
                    $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1);  // convert total monthly days
                    $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                    $allQuantityTotal = $invMasterData->all_quantity_total; // service total
                    $thisMonthPerDay = $allQuantityTotal / $convertMonthlyDays; // per day amount
                    $thisMonthTotal = $thisMonthPerDay * $convertSplitDays; // this month total (per day * split days)
                    $invMasterArr['sub_total'] = $thisMonthTotal; // store sub_total (quantity * unit_price)
                } elseif ($invMasterData->available_till < $invTo) {
                    $availableTill = $invMasterData->available_till;
                    $splitDays = strtotime($availableTill) - strtotime($invFrom); // split Days
                    $convertMonthlyDays = ($totalMonthlyDays / (24 * 60 * 60) + 1);  // convert total monthly days
                    $convertSplitDays = ($splitDays / (24 * 60 * 60) + 1); // convert split monthly days
                    $allQuantityTotal = $invMasterData->all_quantity_total; // service total
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

            $last_invoice_master = DB::table('invoice_masters')
                ->select(

                    DB::raw('SUM(sub_total) as all_service_total'), 'client_id'
                )
                ->where('invoice_id', $last_inv_id->invoice_id)
                ->get();

            foreach ($last_invoice_master as $key => $myValue) {
                DB::table('invoices')
                    ->select('client_vat')
                    ->where('id', $last_inv_id->invoice_id)
                    ->update([
                        'sub_total' => $myValue->all_service_total,
                        'total_amount' => $myValue->all_service_total + (($invArr['client_vat'] / 100) * $myValue->all_service_total)
                    ]);

                DB::table('client_infos')
                    ->where('id', $myValue->client_id)
                    ->update(['mrc_tk' => $myValue->all_service_total + (($invArr['client_vat'] / 100) * $myValue->all_service_total)]);
            }
        }
        Session::flash('msg', 'Invoice successfully Generated.');
        return redirect()->back();
    }
}
