<?php

namespace App\Http\Controllers;
use App\Models\clientInfo;
use App\Models\InvoiceFor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientConfigurationController extends Controller
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
    
    public function clientConfiguration()
    {
        $data = InvoiceFor::all();
        return view('client-configuration', ['data' => $data]);
    }

    public function storeData(Request $request)
    {
        $rules = [
            'client_name' => 'required',
            'client_address' => 'required',
            'vat' => 'required',
            'invoice_type' => 'required',
            'client_type' => 'required',
            'service_location' => 'required',
            'invoice_for' => 'required',
        ];
        $cm = [
            'client_name.required' => 'Enter client name',
            'client_address.required' => 'Enter client address',
            'vat.required' => 'Select client vat',
            'invoice_type.required' => 'Select invoice type',
            'client_type.required' => 'Select client type',
            'service_location.required' => 'Select service location',
            'invoice_for.required' => 'Select invoice for',
        ];
        $this->validate($request, $rules, $cm);
        $client_info = new clientInfo();
        $last_client_id = DB::table('client_infos')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();
        if ($last_client_id !== null) {
            $client_info->id = $last_client_id->id + 1;
        } else {
            $client_info->id = 1;
        }
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
        $client_info->status = "y";       
        $client_info->client_entry_by = Auth::user()->name;
        $client_info->created_at =  Carbon::now();
        $client_info->updated_at =  now();       
        $client_info->save();
        Session::flash('msg', 'Client successfully added');
        return redirect('/client-list');
    }

    public function storeInvoiceFor(Request $request)
    {
        $rules = [
            'invoice_for_name' => 'required',
        ];
        $cm = [
            'invoice_for_name.required' => 'Enter Invoice For',
        ];
        $this->validate($request, $rules, $cm);

        $invoice_for_info = new InvoiceFor();

        $last_invfor_id = DB::table('invoice_fors')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();
        if ($last_invfor_id !== null) {
            $invoice_for_info->id = $last_invfor_id->id + 1;
        } else {
            $invoice_for_info->id = 1;
        }
        $invoice_for_info->invoice_for = $request->invoice_for_name;
        $invoice_for_info->created_by = Auth::user()->name;
        $invoice_for_info->save();
        Session::flash('msg', 'Invoice For successfully added');
        return redirect('/client-configuration');
    }
}
