@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Service Management</li>
        <li class="breadcrumb-item active text-info">Edit Service Configuration</li>
    </ol>

    <div class="fs-4 fw-bold" style="color: red">
        <p>*** Please don't change the service if invoice already exists</p>
    </div> <br>

    @if (Session::has('msg'))
        <p class="alert alert-info">{{ Session::get('msg') }}</p>
    @endif

    <div class="row">
        <div style="width: 700px" class="col">
            <form action="{{ url('update-service-management/' . $editServiceManagement->id) }}" method="POST" class="shadow-lg">
                @csrf
                <div class="form-container row justify-content-center" >
                    <div class="form-group">
                        <input type="text" name="client_name" hidden value="{{ $editServiceManagement->client_id }}">
                    </div>
    
                    <div class="form-group">
                        <input type="text" name="service_name" hidden value="{{ $editServiceManagement->service_id }}">
                    </div>
    
                    <div class="row">
                        <div class="form-group col">
                            <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Quantity<span
                                    style="color: red; font-size: 15px;">*</span></label>
                            <input class="form-control form-control-sm" type="text" id="inputSmall" name="quantity"
                                value="{{ $editServiceManagement->quantity }}">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group col">
                            <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Unit Price<span
                                    style="color: red; font-size: 15px;">*</span></label>
                            <input class="form-control form-control-sm" type="text" id="inputSmall" name="unit_price"
                                value="{{ $editServiceManagement->unit_price }}">
                            @error('unit_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="form-group col">
                            <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Available from<span
                                    style="color: red; font-size: 15px;">*</span></label>
                            <input class="form-control form-control-sm" type="date" id="inputSmall" name="available_from"
                                value="{{ $editServiceManagement->available_from }}">
                        </div>
    
                        <div class="form-group col">
                            <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Available till<span
                                    style="color: red; font-size: 15px;">*</span></label>
                            <input class="form-control form-control-sm" type="date" id="inputSmall" name="available_till"
                                value="{{ $editServiceManagement->available_till }}">
                        </div>
                    </div>
    
    
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Status (y/n)<span
                                style="color: red; font-size: 15px;">*</span></label>
                        <select name="status" id="">
                            <option value="y" {{ $editServiceManagement->status == 'y' ? 'selected' : '' }}>y</option>
                            <option value="n" {{ $editServiceManagement->status == 'n' ? 'selected' : '' }}>n</option>
                        </select>
                    </div>
    
                    <br>
                    <button class="btn btn-info save-btn"
                        onclick="return confirm('Warning! Are you sure to update?')">Update</button>
                </div>
            </form>
        </div>
        
        <div class="col">
            <table id="editable" class="service-name-table table table-striped table-sm">
                <thead>
                    <tr class="bg-gradient text-white fw-normal" style="background-color: #131d36">
                        <th scope="col" style="text-align: center; width: 20px">#</th>
                        <th scope="col" style="text-align: center; width: 200px">Service Name</th>
                        <th scope="col" style="text-align: center; width: 30px">Quantity</th>
                        <th scope="col" style="text-align: center; width: 10px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($viewSubServiceDetails as $key => $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->service_name }}</td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
@endsection
