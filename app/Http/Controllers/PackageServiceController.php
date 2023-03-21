<?php

namespace App\Http\Controllers;

use App\Models\clientBillInfo;
use App\Models\clientInfo;
use App\Models\serviceInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;




use Illuminate\Http\Request;

class PackageServiceController extends Controller
{
    public function packageServiceConfiguration()
    {
        $data = clientInfo::all()->sortBy('client_name');
        // $data2 = serviceInfo::all();
        $data2 = serviceInfo::all()->sortBy('service_name');
        return view('package-service-configuration', ['data' => $data], ['data2' => $data2]);
    }

    public function storePackageService(Request $request)
    {

        $client_bill_infos = new clientBillInfo();

        $last_bill_id = DB::table('client_bill_infos')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();
        if ($last_bill_id !== null) {
            $client_bill_infos->id = $last_bill_id->id + 1;
        } else {
            $client_bill_infos->id = 1;
        }

        $client_bill_infos->client_id = $request->client_id;
        $client_bill_infos->service_id = $request->service_id;
        $client_bill_infos->quantity = $request->quantity;
        $client_bill_infos->unit_price = $request->unit_price;
        $client_bill_infos->available_from = $request->available_from;
        $client_bill_infos->available_till = $request->available_till;
        $client_bill_infos->status = "y";
        $client_bill_infos->inserted_by = Auth::user()->name;
        $client_bill_infos->created_at = Carbon::now();
        $client_bill_infos->updated_at = now();

        $client_bill_infos->save();

        $service_id_pk = $request->service_id_package;
        $quantity_pk = $request->quantity_package;
       

        $last_bill_id_pk = DB::table('client_bill_infos')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->value('id');

        for ($i = 0; $i < count($service_id_pk); $i++) {

            $datasave = [
                'bill_id' => $last_bill_id_pk,
                'client_id' => $request->client_id,
                'service_id' => $service_id_pk[$i],
                'quantity' => $quantity_pk[$i],
                'status' => 'y',
                'created_at' => Carbon::now(),
                'updated_at' => now(),
            ];
            DB::table('bill_details')->insert($datasave);
        }
        Session::flash('msg', 'Service details successfully assigned');
        return redirect()->back();
    }
}
