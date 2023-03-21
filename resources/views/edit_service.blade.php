@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')

<ol class="breadcrumb fs-4 fw-bold">
    <li class="breadcrumb-item">Service Management</li>
    <li class="breadcrumb-item active">Service List</li>
  </ol>
  
  <form action="{{ url('/update-service/'.$editService->id) }}" method="POST">
    @csrf
    <div class="shadow-lg form-container row justify-content-center" style="width: 500px;">
      <div class="form-group service-name-form">
        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Service Name</label>
        <input class="form-control form-control-sm" name="service_name" type="text" id="inputSmall" value="{{ $editService->service_name }}" required>
        @error('service_name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <br>
      <div>
        <input type="submit" class="btn btn-primary" value="Update">
      </div>
    </div>
  </form>
  


@endsection