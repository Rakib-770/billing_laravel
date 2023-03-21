@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')

<div class="fs-4 fw-bold">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Billing</li>
    <li class="breadcrumb-item active text-info">Adhoc Invoice Generation</li>
  </ol>
</div>

@if (Session::has('msg'))
<p class="alert alert-info">{{ Session::get('msg') }}</p>
@endif

<form action="{{ url('/store-adhoc-invoice') }}" class="shadow-sm" method="POST" autocomplete="off">
  @csrf
  <div style="width: 830px" class="form-container row ">
    <div class="col">
      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice for<span
            style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp; &emsp;
        <select class="form-select-sm" id="invoice_for_ID" name="invoice_for" required>
          <option value="" selected>--select invoice for--</option>
          @foreach ($invoice_for as $row)
          <option value="{{ $row->id }}">{{ $row->invoice_for }}</option>
          @endforeach
        </select>
        @error('invoice_for')
        <span class="text text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Client Name<span
            style="color: red; font-size: 15px;">*</span></label> &emsp; &emsp;
        <select class="form-select-sm" id="client_ID" name="client_name" required>
          <option value="">--select client name--</option>
        </select>
        @error('client_name')
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
        <input class="form-control form-control-sm" type="date" value="<?php echo date('Y-m-01'); ?>" id="inputSmall" name="invoice_date" value="<?php echo date('Y-m-d'); ?>" required>
        @error('invoice_date')
        <span class="text text-danger">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div class="col">
      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice From Date<span
            style="color: red; font-size: 15px;">*</span></label>
        <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_from_date" value="<?php echo date('Y-m-01'); ?>" required>
        @error('invoice_from_date')
        <span class="text text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice To Date<span
            style="color: red; font-size: 15px;">*</span></label>
        <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_to_date" value="<?php echo date('Y-m-30'); ?>" required>
        @error('invoice_to_date')
        <span class="text text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-group">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Due Date<span
            style="color: red; font-size: 15px;">*</span></label>
        <input class="form-control form-control-sm" type="date" id="inputSmall" name="invoice_due_date" value="<?php echo date('Y-m-10'); ?>" required>
        @error('invoice_due_date')
        <span class="text text-danger">{{ $message }}</span>
        @enderror
      </div>
      <br>
      <span style="color: red; font-size: 12px;">**If required</span>
      <div class="row">
        <div class="col">
          <input type="text" placeholder="Arrear title" name="arrear_title">
        </div>
        <div class="col">
          <input type="text" placeholder="Arrear amount" name="arrear_amount">
        </div>
      </div>
    </div>
  </div>
  <input type="submit" style="margin-left: 40px" class="btn btn-info" value="Generate Adhoc Invoice">

</form>

<script>
  jQuery(document).ready(function(){
    jQuery('#invoice_for_ID').change(function(){
      let InvForID=jQuery(this).val();
      jQuery.ajax({
        url:'/getClient',
        type:'POST',
        data:'InvForID='+InvForID+
        '&_token={{csrf_token()}}',
        success:function(result){
          jQuery('#client_ID').html(result)
        }
      })
    });
  });

</script>
@endsection