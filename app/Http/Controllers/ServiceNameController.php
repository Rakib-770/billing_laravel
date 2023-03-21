<?php

namespace App\Http\Controllers;
use App\Models\serviceInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ServiceNameController extends Controller
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
    
    // View Service Name Page

    public function serviceName()
    {
        $serviceName = serviceInfo::paginate(50);
        return view('service-name', compact('serviceName'));
    }

    // Store Service information

    public function storeServiceInfo(Request $request)
    {
        $rules = [
            'service_name' => 'required',
        ];
        $cm = [
            'service_name.required' => 'Enter Service Name'
        ];

        $this->validate($request, $rules, $cm);
        $service_info = new serviceInfo();
        $last_service_id = DB::table('service_infos')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();
        if ($last_service_id !== null) {
            $service_info->id = $last_service_id->id + 1;
        } else {
            $service_info->id = 1;
        }

        $service_info->service_name = $request->service_name;
        $service_info->inserted_by = Auth::user()->name;
        $service_info->created_at =  Carbon::now();
        $service_info->save();
        Session::flash('msg', 'Service successfully Created');
        return redirect()->back();
    }

    // Delete The Service

    public function deleteServiceInfo($id = null)
    {
        $deleteData = ServiceInfo::find($id);
        $deleteData->delete();
        Session::flash('msg', 'Service successfully Deleted');
        return redirect()->back();
    }

    public function editService($id = null)
    {
        $editService = serviceInfo::find($id);
        return view('edit_service', compact('editService'));
    }

    public function updateService(Request $request, $id)
    {
        $rules = [
            'service_name' => 'required',
        ];
        $cm = [
            'service_name.required' => 'Enter service name',
        ];
        $this->validate($request, $rules, $cm);
        $service_info = serviceInfo::find($id);

        $service_info->service_name = $request->service_name;
        $service_info->inserted_by = Auth::user()->name;
        $service_info->updated_at = now();
        $service_info->save();
        Session::flash('msg', 'service successfully Updated');
        return redirect('/service-name');
    }
}
