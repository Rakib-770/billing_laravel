@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active text-info">Invoice Details</li>
    </ol>

    <div style="width: 600px" class="row form-container shadow-sm">
        <form action="" method="GET">
            @csrf
            <div class="row">

                <div class="form-group col-sm" style="width: 10px">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Details For<span
                            style="color: red; font-size: 15px;">*</span></label> <br>
                    <select class="form-select-sm" name="invoice_for" id="invoice_for_ID" required>
                        <option value="" disabled selected hidden>Invoice details for</option>
                        @foreach ($data as $row)
                            <option value="{{ $row->id }}">{{ $row->invoice_for }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col form-group col-sm" style="width: 10px">
                    <label class="col-form-label col-form-label-sm mt-4" for="inputSmall">Invoice Month Year<span
                            style="color: red; font-size: 15px;">*</span></label>
                    <input class="form-control form-control-sm" type="text" value="<?php echo date('Y-m'); ?>" id="inputSmall"
                        name="InvMonthYear" required>
                </div>

                <br> <br>
                <div class="col-sm">
                <button type="submit" class="btn btn-info save-btn "
                    style="margin-left: 10px; margin-top: 40px; width: 150px; height: 40px">Report</button>
                </div>
            </div>
        </form>
    </div> <br> <br>

    <table class="table table-striped shadow-sm table-sm" style="width: 600px">
        <thead>
            <tr class="bg-gradient text-white fw-normal" style="background-color: #131d36">
                <th scope="col" style="text-align: center">Inv Month Year</th>
                <th scope="col" style="text-align: center">Inv For</th>
                <th scope="col" style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($showInvoice as $key => $data)
            <tr>
                <td>{{ $data->invoice_month_year }}</td>
                <td>
                    @if ($data->invoice_for == 1)
                        Coloasia
                    @elseif ($data->invoice_for == 2)
                        MCloud
                    @elseif ($data->invoice_for == 3)
                        Bogra POI
                    @elseif ($data->invoice_for == 4)
                        Sylhet POI
                    @elseif ($data->invoice_for == 5)
                        SMS
                    @endif
                </td>
                <td>
                    <a class="" data-toggle="tooltip" data-placement="left" title="View PDF" target="_blank" href="{{ url('pdf-invoice-details/' . $data->invoice_month_year . $data->invoice_for) }}"><img
                        class="my-icon" style="height: 30px; width: 30px" src="images/pdf.png" alt=""></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
