@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Account Management</li>
        <li class="breadcrumb-item active text-info">Client Configuration</li>
    </ol>

    <form action="{{ url('/update-data/' . $editData->id) }}" style="margin-left: 150px" method="POST">
        @csrf
        <div style="width: 700px" class="form-container row justify-content-center shadow-lg">
            <div class="col">
                <div class="form-group">
                    <div>
                        Client ID: {{ $editData->id }}
                    </div>
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Client Name <span
                            style="color: red; font-size: 15px;">*</span></label>
                    <input class="form-control form-control-sm" type="text" name="client_name"
                        value="{{ $editData->client_name }}" id="inputSmall">
                    @error('client_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Client Address<span
                            style="color: red; font-size: 15px;">*</span></label>
                    <textarea class="form-control" id="exampleTextarea" rows="2" name="client_address"
                        value="{{ $editData->client_address }}">{{ $editData->client_address }}</textarea>
                    @error('client_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Contact Person</label>
                    <input class="form-control form-control-sm" type="text" id="inputSmall" name="invoice_contact_person"
                        value="{{ $editData->invoice_contact_person }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Contact Person Designation</label>
                    <input class="form-control form-control-sm" type="text" id="inputSmall"
                        name="contact_person_designation" value="{{ $editData->contact_person_designation }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Contact Person Phone</label>
                    <input class="form-control form-control-sm" type="text" id="inputSmall"
                        name="contact_person_phone" value="{{ $editData->contact_person_phone }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Contact Person Email</label>
                    <input class="form-control form-control-sm" type="email" id="inputSmall" name="contact_person_email"
                        value="{{ $editData->contact_person_email }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">BIN Number</label>
                    <input class="form-control form-control-sm" type="tel" pattern="[0-9\-]+" id="inputSmall"
                        name="bin_number" value="{{ $editData->client_bin_number }}">
                </div>
            </div>
            <br>
            <div class="col" style="margin-left: 70px">

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">NID</label>
                    <input class="form-control form-control-sm" type="tel" pattern="[0-9\-]+" id="inputSmall"
                        name="nid" value="{{ $editData->client_nid }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">PO Number</label>
                    <input class="form-control form-control-sm" type="text" id="inputSmall" name="po_number"
                        value="{{ $editData->client_po_number }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">VAT<span
                            style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp; &emsp; &emsp;
                    <select class="form-select-sm" id="exampleSelect1" name="vat">
                        <option value="5" {{ $editData->client_vat == 5 ? 'selected' : '' }}>5</option>
                        <option value="15" {{ $editData->client_vat == 15 ? 'selected' : '' }}>15</option>
                        <option value="0" {{ $editData->client_vat == 0 ? 'selected' : '' }}>0</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Type<span
                            style="color: red; font-size: 15px;">*</span></label> &emsp;
                    <select class="form-select-sm" id="exampleSelect1" name="invoice_type">
                        <option value="1" {{ $editData->invoice_type == 1 ? 'selected' : '' }}>Pre-Paid</option>
                        <option value="2" {{ $editData->invoice_type == 2 ? 'selected' : '' }}>Post-Paid</option>
                    </select>
                    @error('invoice_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Client Type<span
                            style="color: red; font-size: 15px;">*</span></label> &emsp; &nbsp; &nbsp;
                    <select class="form-select-sm" id="exampleSelect1" name="client_type" required>
                        <option value="" {{ $editData->client_type == '' ? 'selected' : '' }}>--select client type--
                        </option>
                        <option value="Bank" {{ $editData->client_type == 'Bank' ? 'selected' : '' }}>Bank</option>
                        <option value="IGW" {{ $editData->client_type == 'IGW' ? 'selected' : '' }}>IGW</option>
                        <option value="ICX" {{ $editData->client_type == 'ICX' ? 'selected' : '' }}>ICX</option>
                        <option value="ANS" {{ $editData->client_type == 'ANS' ? 'selected' : '' }}>ANS</option>
                        <option value="Sister Concern" {{ $editData->client_type == 'Sister Concern' ? 'selected' : '' }}>
                            Sister
                            Concern</option>
                        <option value="SMS" {{ $editData->client_type == 'SMS' ? 'selected' : '' }}>SMS</option>
                        <option value="IOF" {{ $editData->client_type == 'IOF' ? 'selected' : '' }}>IOF</option>
                        <option value="ISP" {{ $editData->client_type == 'ISP' ? 'selected' : '' }}>ISP</option>
                        <option value="Hosting" {{ $editData->client_type == 'Hosting' ? 'selected' : '' }}>Hosting
                        </option>
                        <option value="MCloud" {{ $editData->client_type == 'MCloud' ? 'selected' : '' }}>MCloud</option>
                        <option value="IIG" {{ $editData->client_type == 'IIG' ? 'selected' : '' }}>IIG</option>
                        <option value="Other" {{ $editData->client_type == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Service Location<span
                            style="color: red; font-size: 15px;">*</span></label> &nbsp;
                    <select class="form-select-sm" id="exampleSelect1" name="service_location" required>
                        <option value="" {{ $editData->service_location == '' ? 'selected' : '' }}>--select
                            location--</option>
                        <option value="Borak" {{ $editData->service_location == 'Borak' ? 'selected' : '' }}>Borak
                        </option>
                        <option value="Gulshan" {{ $editData->service_location == 'Gulshan' ? 'selected' : '' }}>Gulshan
                        </option>
                        <option value="Bogra" {{ $editData->service_location == 'Bogra' ? 'selected' : '' }}>Bogra
                        </option>
                        <option value="Jessore" {{ $editData->service_location == 'Jessore' ? 'selected' : '' }}>Jessore
                        </option>
                        <option value="Sylhet" {{ $editData->service_location == 'Sylhet' ? 'selected' : '' }}>Sylhet
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Activation Date</label>
                    <input class="form-control form-control-sm" type="date" id="inputSmall" name="activation_date"
                        value="{{ $editData->client_activation_date }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Inactive Date</label>
                    <input class="form-control form-control-sm" type="date" id="inputSmall" name="inactive_date"
                        value="{{ $editData->client_inactivation_date }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice for<span
                            style="color: red; font-size: 15px;">*</span></label> &emsp;
                    <select class="form-select-sm" id="exampleSelect1" name="invoice_for"
                        value="{{ $editData->invoice_for == '' ? 'selected' : ''  }}">
                        <option value="1" {{ $editData->invoice_for == '1' ? 'selected' : '' }}>Coloasia
                        </option>
                        <option value="2" {{ $editData->invoice_for == '2' ? 'selected' : '' }}>MCloud</option>
                        <option value="3" {{ $editData->invoice_for == '3' ? 'selected' : '' }}>Bogra POI
                        </option>
                        <option value="4" {{ $editData->invoice_for == '4' ? 'selected' : '' }}>Sylhet POI
                        </option>
                        <option value="5" {{ $editData->invoice_for == '5' ? 'selected' : '' }}>SMS</option>
                    </select>
                    @error('invoice_for')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Status<span
                            style="color: red; font-size: 15px;">*</span></label> &emsp;
                    <select class="form-select-sm" id="exampleSelect1" name="status">
                        <option value="y" {{ $editData->status == 'y' ? 'selected' : '' }}>y</option>
                        <option value="n" {{ $editData->status == 'n' ? 'selected' : '' }}>n</option>
                    </select>
                    @error('invoice_for')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                <br>
                <input type="submit" class="btn btn-info" value="Update">
            </div>
        </div>
    </form>
@endsection
