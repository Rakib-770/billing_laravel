@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Service Management</li>
        <li class="breadcrumb-item active text-info">Service List</li>
    </ol>

    <div style="margin-left: 250px">
        <form action="{{ url('/store-service-info') }}" method="POST">
            @csrf
            <div class="shadow-sm form-container row justify-content-center" style="width: 500px;">
                <div class="form-group service-name-form">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Service Name</label>
                    <input class="form-control form-control-sm" name="service_name" type="text" id="inputSmall" required>
                    @error('service_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div>
                    <input type="submit" class="btn btn-info" value="Create">
                    <input type="reset" class="btn btn-outline-secondary" value="Clear">
                </div>
            </div>
        </form>
    </div>

    @if (Session::has('msg'))
        <p class="alert alert-info">{{ Session::get('msg') }}</p>
    @endif
    <br>
    <h3>
        All Service List
    </h3>
    <br>
    {{ $serviceName->render() }}

    <table class="service-name-table table table-striped table-sm" style="width: 70%">
        <thead>
            <tr class="bg-gradient text-white fw-normal" style="background-color: #131d36">
                <th scope="col" style="text-align: center">#ID</th>
                <th scope="col" style="text-align: center">Service Name</th>
                <th scope="col" style="text-align: center">Inserted by</th>
                <th scope="col" style="text-align: center">Created at</th>
                <th scope="col" style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceName as $key => $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td style="width: 400px; text-align: left">{{ $data->service_name }}</td>
                    <td>{{ $data->inserted_by }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        <div class="d-flex justify-content-around">
                            <div class="myDeleteLink">
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ url('delete-service-info/' . $data->id) }}"
                                        onclick="return confirm('Are you sure to delete?')">
                                        <img class="my-icon" src="images/trash.svg" alt="">
                                    </a>
                                @else
                                    <a style="pointer-events: none; href="{{ url('delete-service-info/' . $data->id) }}"
                                        onclick="return confirm('Are you sure to delete?')">
                                        <img class="my-icon" src="images/trash.svg" alt="">
                                    </a>
                                @endif
                            </div>
                            <div class="myEditLink">
                                <a href="{{ url('edit-service/' . $data->id) }}">
                                    <img class="my-icon" src="images/edit.svg" alt="">
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $serviceName->render() }}
@endsection
