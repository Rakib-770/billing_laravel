@extends('layouts.sidebar')
@extends('layouts.app')

@section('maincontent')
<ol class="breadcrumb fs-4 fw-bold">
    <li class="breadcrumb-item">Billing</li>
    <li class="breadcrumb-item active text-info">Invoice Generation</li>
</ol>

@if (Session::has('msg'))
<p class="alert alert-info">{{ Session::get('msg') }}</p>
@endif

<form action="{{ url('/store-invoice') }}" method="POST" >
    @csrf
    <div style="width: 700px" class="form-container row shadow-sm">
        <div class="col">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice For<span
                        style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp; &emsp;
                <select class="form-select-sm" name="invoice_for" id="invoiceFor" required>
                    <option value="" disabled selected hidden>select invoice for</option>
                    @foreach($data as $row)
                    <option value="{{ $row->id }}">{{ $row->invoice_for }}</option>
                    @endforeach
                </select>
                @error('invoice_for')
                <span class="text text-danger">{{ $message }}</span>
                @enderror <br>
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice type<span
                        style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp;
                <select class="form-select-sm" id="exampleSelect1" name="invoice_type" required>

                    <option value="" disabled selected hidden>select invoice type</option>
                    <option value="1">Pre-paid</option>
                    <option value="2">Post-paid</option>
                </select> <br>
                @error('invoice_type')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Month Year<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input class="form-control form-control-sm" type="text" value="<?php echo date('Y-m'); ?>" id="inputSmall" name="invoice_month_year" required> 
                @error('invoice_month_year')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Date<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_date" required
                    value="<?php echo date('Y-m-01'); ?>">
                @error('invoice_date')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="col">

            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice From Date<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_from_date" required
                    value="<?php echo date('Y-m-01'); ?>">
                @error('invoice_from_date')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice To Date<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_to_date" required
                    value="<?php echo date('Y-m-30'); ?>">
                @error('invoice_to_date')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Due Date<span
                        style="color: red; font-size: 15px;">*</span></label>
                <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_due_date" required
                    value="<?php echo date('Y-m-10'); ?>">
                @error('invoice_due_date')
                <span class="text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <br>
            <input type="submit" class="btn btn-info" value="Generate Invoice">
        </div>
    </div>
</form>

@endsection