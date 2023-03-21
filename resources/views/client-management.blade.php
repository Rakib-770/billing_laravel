@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')

<ol class="breadcrumb fs-4 fw-bold">
  <li class="breadcrumb-item">Service Management</li>
  <li class="breadcrumb-item active text-info">Service Configuration</li>
</ol>

@if(Session::has('msg'))
<p class="alert alert-info">{{ Session::get('msg') }}</p>
@endif

<form action="{{ url('/store-service-management') }}" method="POST" autocomplete="off">
  @csrf
  <table class="table table-striped table-sm">
    <thead>
      <tr class="bg-gradient text-white fw-normal" style="background-color: #131d36">
        <th scope="col">Client Name</th>
        <th scope="col">Service Name</th>
        <th scope="col">Unit Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Available From</th>
        <th scope="col">Available till</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <select class="form-select-sm" id="exampleSelect1" required name="client_id[]" style="width: 200px">
            <option value="" disabled selected hidden>--select client name--</option>
            @foreach($data as $row)
            <option value="{{ $row->id }}">{{ $row->client_name }} (ID: {{ $row->id }})</option>
            @endforeach
          </select>
        </td>
        <td>
          <select class="form-select-sm" id="exampleSelect1" required name="service_id[]" style="width: 200px">
            <option value="" disabled selected hidden>--select service name--</option>
            @foreach($data2 as $row)
            <option value="{{ $row->id }}">{{ $row->service_name }}</option>
            @endforeach
          </select>
        </td>
        <td><input class="form-control form-control-sm" type="number" step="0.01" id="inputSmall" name="unit_price[]" required></td>
        <td><input class="form-control form-control-sm" type="number" step="0.001" id="inputSmall" name="quantity[]" required></td>
        <td><input class="form-control form-control-sm" type="date" id="inputSmall" name="available_from[]" required
            value="<?php echo date('Y-m-d'); ?>"></td>
        <td><input class="form-control form-control-sm" type="date" id="inputSmall" name="available_till[]" required
            value="<?php echo date('Y-m-d', strtotime('+2922 days')); ?>"></td>
        {{-- <td><button class="btn btn-primary" id="add_btn">+</button></td> --}}
        <td><input type="button" class="btn btn-info fw-bold" id="add_btn" value="+"></td>
      </tr>
    </tbody>
  </table>
  <button class="btn btn-info save-btn" type="submit">Save</button>
  <input type="reset" class="btn btn-outline-secondary" style="width: 100px; height:40px; margin-top:14px; margin-left:5px"
    value="Clear">
</form>


<script type="text/javascript">
  $(document).ready(function(){
    $('#add_btn').on('click',function(){
      var html='';
      html+='<tr>';
      html+='<td> <select class="form-select-sm" id="exampleSelect1" name="client_id[]" style="width: 200px" required> @foreach($data as $row) <option value="{{ $row->id }}">{{ $row->client_name }} (ID: {{ $row->id }})</option> @endforeach </select> </td>';
      html+='<td> <select class="form-select-sm" id="exampleSelect1" name="service_id[]" style="width: 200px" required> @foreach($data2 as $row) <option value="{{ $row->id }}">{{ $row->service_name }}</option> @endforeach </select> </td>';
      html+='<td><input class="form-control form-control-sm" type="number" step="0.01" id="inputSmall" name="unit_price[]" required></td>';
      html+='<td><input class="form-control form-control-sm" type="number" step="0.001" id="inputSmall" name="quantity[]" required></td>';
      html+='<td><input class="form-control form-control-sm" type="date" id="inputSmall" name="available_from[]" required value="<?php echo date('Y-m-d'); ?>"> </td>';
      html+='<td><input class="form-control form-control-sm" type="date" id="inputSmall" name="available_till[]" required value="<?php echo date('Y-m-d', strtotime('+2922 days')); ?>"></td>';
      html+='<td><input type="button" class="btn btn-danger" id="remove" value="-"></td>';
      html+='</tr>';
      $('tbody').append(html);
    })
  });

  $(document).on('click', '#remove',function(){
    $(this).closest('tr').remove();
  });
</script>

@endsection