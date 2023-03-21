@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')

<ol class="breadcrumb fs-4 fw-bold">
    <li class="breadcrumb-item">Account Management</li>
    <li class="breadcrumb-item active text-info">Client Configuration</li>
</ol>

<!-- Modal -->
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/store-invoice-for') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-container row justify-content-center">
                        <div class="form-group">
                            <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Add
                                Invoice For</label>
                            <input class="form-control form-control-sm" type="text" name="invoice_for_name">
                            @error('invoice_for_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Save</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

{{-- End of Pop-up for adding invoice for --}}

@if (Session::has('msg'))
<p class="alert alert-info">{{ Session::get('msg') }}</p>
@endif

<form action="{{ url('/store-data') }}" style="margin-left: 180px" method="POST" autocomplete="off">
    @csrf

    <div style="width: 700px"  class="shadow-sm form-container row justify-content-center">
        <div class="col">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="inputSmall">Client Name<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" name="client_name" id="inputSmall" required>
                @error('client_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="inputSmall">Client Address<span
                        style="color: red; font-size: 15px;">*</span></label>
                <textarea class="form-control" id="exampleTextarea" rows="2" name="client_address" required></textarea>
                @error('client_address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Invoice Contact Person</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" id="inputSmall" name="invoice_contact_person">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Contact Person Designation</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" id="inputSmall"
                    name="contact_person_designation">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Contact Person Phone</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" value="<?php echo "880"; ?>" id="inputSmall" name="contact_person_phone">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Contact Person Email</label>
                <input autocomplete="false" class="form-control form-control-sm" type="email" id="inputSmall" name="contact_person_email">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">BIN Number</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" pattern="[0-9\-]+" id="inputSmall" name="bin_number">
            </div>

        </div>
        <br>

        <div class="col" style="margin-left: 70px">

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">NID</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" pattern="[0-9\-]+" id="inputSmall" name="nid">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">PO Number</label>
                <input autocomplete="false" class="form-control form-control-sm" type="text" id="inputSmall" name="po_number">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">VAT<span
                    style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp; &emsp;
                &emsp;
                <select style="float: right; margin-top:10px" class="form-select-sm" id="exampleSelect1" name="vat" required>
                    <option value="" disabled selected hidden>--select vat--</option>
                    <option>5</option>
                    <option>15</option>
                    <option>0</option>
                </select> <br>
                @error('vat')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Invoice Type<span
                        style="color: red; font-size: 15px;">*</span></label> &emsp;
                <select style="float: right; margin-top:10px" class="form-select-sm" id="exampleSelect1" name="invoice_type" required>
                    <option value="" disabled selected hidden>--select invoice type--</option>
                    <option value="1">Pre-Paid-1</option>
                    <option value="2">Post-Paid-2</option>
                </select> <br>
                @error('invoice_type')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Client Type<span
                    style="color: red; font-size: 15px;">*</span></label> &emsp; &nbsp;
                &nbsp;
                <select style="float: right; margin-top:5px" class="form-select-sm" id="exampleSelect1" name="client_type" required>
                    <option value="" disabled selected hidden>--select client type--</option>
                    <option>Bank</option>
                    <option>IGW</option>
                    <option>ICX</option>
                    <option>ANS</option>
                    <option>Sister Concern</option>
                    <option>SMS</option>
                    <option>IOF</option>
                    <option>ISP</option>
                    <option>Hosting</option>
                    <option>MCloud</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Service Location<span
                    style="color: red; font-size: 15px;">*</span></label> &nbsp;
                <select style="float: right;margin-top:5px" class="form-select-sm" id="exampleSelect1" name="service_location" required>
                    <option value="" disabled selected hidden>--select service location--</option>
                    <option>Borak</option>
                    <option>Gulshan</option>
                    <option>Bogra</option>
                    <option>Jessore</option>
                    <option>Sylhet</option>
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Activation Date</label>
                <input autocomplete="false" class="form-control form-control-sm" type="date" id="inputSmall" name="activation_date"
                    value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Inactive Date</label>
                <input autocomplete="false" class="form-control form-control-sm" type="date" id="inputSmall" name="inactive_date"
                    value="<?php echo date('Y-m-d', strtotime('+2922 days')); ?>">
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-2" for="inputSmall">Invoice for<span
                        style="color: red; font-size: 15px;">*</span></label> &emsp;
                <select class="form-select-sm" id="exampleSelect1" name="invoice_for">
                    @foreach ($data as $row)
                    <option value="" disabled selected hidden>--select invoice for--</option>
                    <option value="{{ $row->id }}">{{ $row->invoice_for }}</option>
                    @endforeach
                </select>
                <br>
            </div>
            <br>
            <input type="submit" class="btn btn-info" style="width: 150px" value="Submit">
            <input type="reset" class="btn btn-outline-secondary" style="width: 100px" value="Clear">
        </div>
    </div>
</form> <br>

{{-- Start of pop-up for adding invoice for --}}
<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Click here to add invoice for
</button> --}}


@endsection