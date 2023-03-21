<?php

namespace App\Http\Controllers;

use App\Models\clientInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientListController extends Controller
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

    // View Client List

    // public function clientList()
    // {
    //     $clientList = clientInfo::paginate(50);
    //     return view('client-list', compact('clientList'));
    // }

    public function clientList(Request $request)
    {
        $search = $request['search'] ?? "";

        if ($search != "") {
            $clientList = clientInfo::where('client_name','LIKE',"%$search%")->paginate(50);
        } else {
            $clientList = clientInfo::paginate(50);
        }
        $data = compact('clientList', 'search');
        return view('client-list')->with($data);
    }

    // Edit Client from ClientList

    public function editData($id = null)
    {
        $editData = clientInfo::find($id);
        return view('edit_data', compact('editData'));
    }

    // Update Client from ClientList

    public function updateData(Request $request, $id)
    {
        $rules = [
            'client_name' => 'required',
            'client_address' => 'required',
            'invoice_type' => 'required',
            'invoice_for' => 'required',
            'status' => 'required',
        ];
        $cm = [
            'client_name.required' => 'Enter client name',
            'client_address.required' => 'Enter client address',
            'invoice_type.required' => 'Select invoice type',
            'invoice_for.required' => 'Select invoice for',
            'status.required' => 'Please select status',
        ];
        $this->validate($request, $rules, $cm);
        $client_info = clientInfo::find($id);

        $client_info->client_name = $request->client_name;
        $client_info->client_address = $request->client_address;
        $client_info->invoice_contact_person = $request->invoice_contact_person;
        $client_info->contact_person_designation = $request->contact_person_designation;
        $client_info->contact_person_phone = $request->contact_person_phone;
        $client_info->contact_person_email = $request->contact_person_email;
        $client_info->client_bin_number = $request->bin_number;
        $client_info->client_nid = $request->nid;
        $client_info->client_po_number = $request->po_number;
        $client_info->client_vat = $request->vat;
        $client_info->invoice_type = $request->invoice_type;
        $client_info->client_type = $request->client_type;
        $client_info->service_location = $request->service_location;
        $client_info->client_activation_date = $request->activation_date;
        $client_info->client_inactivation_date = $request->inactive_date;
        $client_info->invoice_for = $request->invoice_for;
        $client_info->status = $request->status;
        $client_info->client_entry_by = Auth::user()->name;
        $client_info->updated_at = now();
        $client_info->save();
        Session::flash('msg', 'Client successfully Updated');
        return redirect('/client-list');
    }

    // Delete Client from ClientList

    public function deleteData($id = null)
    {
        $deleteData = clientInfo::find($id);
        $deleteData->delete();
        Session::flash('msg', 'Client successfully Deleted');
        return redirect('/client-list');
    }
}
