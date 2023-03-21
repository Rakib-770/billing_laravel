@extends('layouts.sidebar')
@extends('layouts.app')
@section('maincontent')
    <ol class="breadcrumb fs-4 fw-bold">
        <li class="breadcrumb-item">Billing</li>
        <li class="breadcrumb-item">Invoice Index</li>
        <li class="breadcrumb-item active text-info">View Batch</li>
    </ol>

    @if (Session::has('msg'))
        <p class="alert alert-info">{{ Session::get('msg') }}</p>
    @endif
    @if (Session::has('msg2'))
        <p class="alert alert-danger">{{ Session::get('msg2') }}</p>
    @endif

    @foreach ($batch_invoice_details as $key => $data)
  @if ($data->batch_number == $last_batch_number && $client_count != 1)
    <a href="#" class="btn btn-danger" id="deleteAll" onclick="return confirm('Warning! Are you sure to delete incoice?')">Delete All</a>
    @break
  @else
    <button class="btn btn-danger" disabled>Delete All</button>
    @break
  @endif
@endforeach

    {{-- @foreach ($batch_invoice_details as $key => $data)
        @if ($data->batch_number == $last_batch_number)
            <a href="#" class="btn btn-danger" id="deleteAll"
                onclick="return confirm('Warning! Are you sure to delete incoice?')">Delete All</a>
        @break

    @elseif ($value_count == 1)
        <a href="#" class="btn btn-danger" id="deleteAll"
            onclick="return confirm('Warning! Are you sure to delete incoice?')">Delete All</a>
    @break

@else
    <button class="btn btn-danger" disabled>Delete All</button>
@break
@endif
@endforeach --}}

{{-- <a href="#" class="btn btn-danger" id="deleteAll">Delete All</a> --}}
<br> <br>

<table class="table table-sm table-striped">
<thead>
<tr class="bg-gradient text-white fw-normal" style="text-align: center; background-color: #131d36">
    <th scope="col"><input type="checkbox" id="checkAll"></th>
    <th scope="col">Batch no</th>
    <th scope="col">Client ID</th>
    <th scope="col">Client Name</th>
    <th scope="col">Inv type</th>
    <th scope="col">Inv For</th>
    <th scope="col">Inv from date</th>
    <th scope="col">Inv to date</th>
    <th scope="col">Action</th>
</tr>
</thead>
<tbody>
@foreach ($batch_invoice_details as $key => $data)
    <tr id="iid{{ $data->id }}">
        <td><input type="checkbox" name="ids" class="checkBoxclass" value="{{ $data->id }}">
        </td>
        <td>{{ $data->batch_number }}</td>
        <td>{{ $data->client_id }}</td>
        <td style="text-align: left">{{ $data->client_name }}</td>
        <td>
            @if ($data->invoice_type == 1)
                Pre-paid
            @elseif ($data->invoice_type == 2)
                Post-paid
            @endif
        </td>
        <td>
            @if ($data->invoice_for == 1)
                Coloasia-1
            @elseif ($data->invoice_for == 2)
                MCloud-2
            @elseif ($data->invoice_for == 3)
                Bogra POI-3
            @elseif ($data->invoice_for == 4)
                Sylhet POI
            @elseif ($data->invoice_for == 5)
                SMS
            @endif
        </td>
        <td>{{ $data->invoice_from_date }}</td>
        <td>{{ $data->invoice_to_date }}</td>

        <td>
            {{-- @if ($data->batch_number == $last_batch_number)
                <a class="btn btn-outline-danger" href="{{ url('delete-inv/' . $data->id) }}"
                    onclick="return confirm('Warning! Are you sure to delete incoice?')"><img class="my-icon"
                        src="/images/reddelete.png" alt=""></a>
            @else
                <button class="btn btn-danger" disabled><img class="my-icon" src="/images/reddelete.png"
                        alt=""></button>
            @endif --}}
            <a class="btn btn-outline-danger" href="{{ url('delete-inv/' . $data->id) }}"
              onclick="return confirm('Warning! Are you sure to delete incoice?')"><img class="my-icon"
                  src="/images/reddelete.png" alt=""></a>
        </td>
    </tr>
@endforeach

</tbody>
</table>

<script>
    $(function(e) {
        $("#checkAll").click(function() {
            $(".checkBoxclass").prop('checked', $(this).prop('checked'));
        });

        $("#deleteAll").click(function(e) {
            e.preventDefault();
            var allids = [];

            $("input:checkbox[name=ids]:checked").each(function() {
                allids.push($(this).val());
            });

            $.ajax({
                url: "{{ route('batch-invoice-details.deleteChecked') }}",
                type: "DELETE",
                data: {
                    _token: $("input[name=_token]").val(),
                    ids: allids
                },
                success: function(response) {
                    $.each(allids, function(key, val) {
                        $("#iid" + val).remove();
                    })
                }
            });
        })
    });
</script>
@endsection
