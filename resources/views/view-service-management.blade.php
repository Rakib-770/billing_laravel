@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Service Management</li>
        <li class="breadcrumb-item active text-info">View Configuration</li>
    </ol>

    <div class="" style="width: 60%">
        <form class="row" action="" method="POST">
            @csrf
            <div style="margin-left: 40px" class="col form-group">
                <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Client Name</label> &emsp; &nbsp;
                <select class="form-select-sm" id="exampleSelect1" name="client_name" required>
                    <option value="" disabled selected hidden>--select client name--</option>
                    @foreach ($data as $row)
                        <option value="{{ $row->id }}">{{ $row->client_name }} (ID: {{ $row->id }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col" style="margin-top: 30px">
                <button style="margin: 20px" class="btn btn-info save-btn">Show details</button>

            </div>
        </form>
    </div>
    <br>

    <table class="table table-striped shadow-lg table-sm">
        <thead>
            <tr class="bg-gradient text-white fw-normal" style="background-color: #131d36">
                <th scope="col" style="text-align: center">ID</th>
                <th scope="col" style="text-align: center">Client Name</th>
                <th scope="col" style="text-align: center">Service Name</th>
                <th scope="col" style="text-align: center">Quantity</th>
                <th scope="col" style="text-align: center">Unit price</th>
                <th scope="col" style="text-align: center">Available from</th>
                <th scope="col" style="text-align: center">Available till</th>
                <th scope="col" style="text-align: center">Status</th>
                <th scope="col" style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewManagement as $row)
                @if ($row->status == "y")
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->client_name }}</td>
                        <td>{{ $row->service_name }}</td>
                        <td>{{ $row->quantity }}</td>
                        <td>{{ $row->unit_price }}</td>
                        <td>{{ $row->available_from }}</td>
                        <td>{{ $row->available_till }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <div class="myEditLink">
                                <a href="{{ url('edit-service-management/' . $row->id) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"> <img
                                        class="my-icon" src="images/edit.svg" alt=""></a>  &nbsp; &nbsp;
                                        
                                        <a href="" target="_blank" data-toggle="tooltip" data-placement="top" title="View configuration"> <img
                                            class="my-icon" src="images/view.png" alt=""></a>
                            </div>
                        </td>
                    </tr>
                @else
                    <tr style="background-color: rgb(255, 163, 163)">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->client_name }}</td>
                        <td>{{ $row->service_name }}</td>
                        <td>{{ $row->quantity }}</td>
                        <td>{{ $row->unit_price }}</td>
                        <td>{{ $row->available_from }}</td>
                        <td>{{ $row->available_till }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <div class="myEditLink">
                                <a href="{{ url('edit-service-management/' . $row->id) }}" target="_blank"> <img
                                        class="my-icon" src="images/edit.svg" alt=""></a> &nbsp; &nbsp;
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
