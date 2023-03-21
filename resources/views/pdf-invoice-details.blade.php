<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Details</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            margin-top: 50px;
            margin-right: 20px;
            margin-left: 20px;
        }

        .invDetailTitle {
            text-align: center;
        }

        .mainContent {
            margin-top: 20px;
        }
    </style>

</head>


@foreach ($final_arr as $row)

    <body>
        <div style="background-color: rgb(196, 196, 196); padding: 1px">
            <h3 class="invDetailTitle">Invoice Details</h3>
        </div>

        <div class="mainContent">
            <div>
                <table>
                    <tr style="font-weight: bold;">
                        <td class="tdTitle">Invoice No:</td>
                        <td style="text-align: left">
                            {{ $row['invoice_info']->invoice_month_year }}-{{ $row['invoice_info']->client_id }}-{{ $row['invoice_info']->invID }}
                        </td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td class="tdTitle" style="vertical-align: top">Invoice Month:</td>
                        <td style="text-align: left">{{ $row['invoice_info']->invoice_month_year }}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td class="tdTitle" style="vertical-align: top">Client Name:</td>
                        <td style="text-align: left">{{ $row['invoice_info']->client_name }}</td>
                    </tr>
                </table>
            </div> <br> <br>

            <div>
                <table class="table table-sm" style="width: 60%">
                    <thead style="border: 1px solid black; width: 100%;">
                        <tr style="background-color: rgb(196, 196, 196);">
                            <th scope="col" style="width: 30%">Services</th>
                            <th scope="col" style="width: 20%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody style="border: 1px solid black; width: 100%" class="">
                        @foreach ($row['services'] as $key => $srow)
                            <tr>
                                <th class=" " style="border: .5px solid black;">{{ $srow->service_name }} </th>
                                <td style="width: 20%; text-align: center; border: .5px solid black"
                                    class="mainContent">
                                    {{ $srow->quantity }}
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
@endforeach

</html>
