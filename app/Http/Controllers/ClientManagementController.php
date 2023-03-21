<?php

namespace App\Http\Controllers;

use App\Models\clientInfo;
use App\Models\serviceInfo;
use App\Models\clientBillInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientManagementController extends Controller
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

    // View Client management

    public function clientManagement()
    {
        $data = clientInfo::all()->sortBy('client_name');
        // $data2 = serviceInfo::all();
        $data2 = serviceInfo::all()->sortBy('service_name');
        return view('client-management', ['data' => $data], ['data2' => $data2]);
    }

    public function viewManagement(Request $request)
    {
        $client_name = $request->client_name;
        $data = clientInfo::all()->sortBy('client_name');
        $viewManagement = DB::table('client_bill_infos')
            ->join('client_infos', 'client_infos.id', '=', 'client_bill_infos.client_id')
            ->join('service_infos', 'service_infos.id', '=', 'client_bill_infos.service_id')
            ->select('client_bill_infos.*', 'client_infos.client_name', 'service_infos.service_name')
            ->where('client_id', $client_name)
            ->orderBy('status', 'desc')
            ->get();
            
        return view('view-service-management', ['data' => $data], compact('viewManagement'));
    }

    // Store Services for client
    public function storeServiceManagement(Request $request)
    {
        $client_id = $request->client_id;
        $service_id = $request->service_id;
        $quantity = $request->quantity;
        $unit_price = $request->unit_price;
        $available_from = $request->available_from;
        $available_till = $request->available_till;

        for ($i = 0; $i < count($client_id); $i++) {
            $last_management_id = DB::table('client_bill_infos')
                ->select('id')
                ->orderBy('id', 'DESC')
                ->first();

            $datasave = [
                'client_id' => $client_id[$i],
                'service_id' => $service_id[$i],
                'quantity' => $quantity[$i],
                'unit_price' => $unit_price[$i],
                'available_from' => $available_from[$i],
                'available_till' => $available_till[$i],
                'status' => "y",
                'inserted_by' => Auth::user()->name,
                'created_at' => Carbon::now(),
                'updated_at' => now(),
            ];
            DB::table('client_bill_infos')->insert($datasave);
        }
        Session::flash('msg', 'Service successfully assigned');
        return redirect()->back();
    }

    public function editManagement($id = null)
    {
        $editServiceManagement = clientBillInfo::find($id);
        $viewSubServiceDetails = DB::table('bill_details')
        ->join('service_infos', 'service_infos.id', '=', 'bill_details.service_id')
            ->where('bill_id', $id)
            ->get();

        return view('edit-service-management', compact('editServiceManagement', 'viewSubServiceDetails'));
    }

    public function updateManagement(Request $request, $id)
    {
        $rules = [
            'quantity' => 'required',
            'unit_price' => 'required',
            'available_from' => 'required',
            'available_till' => 'required',
            'status' => 'required',
        ];
        $cm = [
            'quantity.required' => 'Enter service quantity',
            'unit_price.required' => 'Enter unit price',
            'available_from.required' => 'Select available from date',
            'available_till.required' => 'Select available till date',
        ];
        $this->validate($request, $rules, $cm);
        $service_management = clientBillInfo::find($id);

        $service_management_bill_details = DB::table('bill_details')
        // ->select('status')
        ->where('bill_id', '=', $id)
        ->update([
            'status' => $request->status
      ]);
        // print_r($service_management_bill_details);
        // exit();

        $service_management->client_id = $request->client_name;
        $service_management->service_id = $request->service_name;
        $service_management->quantity = $request->quantity;
        $service_management->unit_price = $request->unit_price;
        $service_management->available_from = $request->available_from;
        $service_management->available_till = $request->available_till;
        $service_management->status = $request->status;

        // $service_management_bill_details->status = $request->status;

        $service_management->inserted_by = Auth::user()->name;
        $service_management->updated_at =  now();
        $service_management->save();
        // $service_management_bill_details->save();
        Session::flash('msg', 'Assigned service successfully updated');
        return redirect('/view-service-management');
    }
}
