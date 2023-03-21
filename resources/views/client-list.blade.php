@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Account Management</li>
        <li class="breadcrumb-item active text-info">Client List</li>
    </ol>

    <!-- Table start -->
    @if (Session::has('msg'))
        <p class="alert alert-info">{{ Session::get('msg') }}</p>
    @endif

    <form action="" class="col-9" autocomplete="off">
        <div class="row" style="width: 70%">
            <div class="form-group col">
                <input type="search" name="search" id="" placeholder="search client" class="form-control"
                    value="{{ $search }}">
            </div>
            <div class="col">
                <button class="btn btn-info">Search</button>
                <a href="{{ url('/client-list') }}">
                    <button class="btn btn-outline-secondary" type="button">Reset</button>
                </a>
            </div>
        </div>
    </form> <br>

    <table class="table table-striped table-sm">
        <thead>
            <tr class="bg-gradient text-white" style="background-color: #131d36">
                <th style="text-align: center">#ID</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Inv type</th>
                <th style="text-align: center">Client type</th>
                <th style="text-align: center">Location</th>
                <th style="text-align: center">VAT(%)</th>
                <th style="text-align: center">Total MRC(TK)</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientList as $key => $data)
                <tr>
                    <td style="width: 5px" name="name">
                        {{ $data->id }}
                    </td>
                    <td style="width: 150px">
                        <div style="text-align: left">
                            {{ $data->client_name }}

                        </div>
                    </td>
                    <td style="width: 50px">
                        @if ($data->invoice_type == 1)
                            Pre-paid
                        @elseif ($data->invoice_type == 2)
                            Post-paid
                        @endif
                    </td>
                    <td style="width: 50px">
                        {{ $data->client_type }}
                    </td>
                    <td style="width: 50px">
                        {{ $data->service_location }}
                    </td>
                    <td style="width: 50px">
                        {{ $data->client_vat }}
                    </td>
                    <td style="width: 50px">
                        {{-- @php
                            $formatter = new NumberFormatter('BDT', NumberFormatter::CURRENCY);
                            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                            echo $formatter->format($data->mrc_tk);
                        @endphp --}}
                    </td>
                    <td style="width: 1px">
                        @if ( $data->status == 'y')
                            <span class="badge rounded-pill bg-success">active</span>
                        @else
                            <span class="badge rounded-pill bg-danger">inactive</span>
                        @endif
                    </td>
                    <td style="width: 1px">
                        <div class="d-flex justify-content-around">
                            <div class="">
                                <a class="" href="{{ url('edit-data/' . $data->id) }}">
                                    <img class="my-icon" src="images/edit.svg" alt="">
                                </a>
                            </div>
                            <div class="">
                                @if (Auth::user()->role == 'admin')
                                    <a class="" href="{{ url('delete-data/' . $data->id) }}"
                                        onclick="return confirm('Warning! Are you sure to delete client?')">
                                        <img class="my-icon" src="images/trash.svg" alt="">
                                    </a>
                                @else
                                    <a class="" style="pointer-events: none;" href="{{ url('delete-data/' . $data->id) }}"
                                        onclick="return confirm('Warning! Are you sure to delete client?')">
                                        <img class="my-icon" src="images/trash.svg" alt="">
                                    </a>
                                @endif
                            </div>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tbody id="Content">
        </tbody>
    </table>

    {{-- {{ $clientList->links() }} --}}
    {{ $clientList->render() }}
@endsection
