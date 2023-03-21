<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            margin-top: 100px;
        }

        .invHead {
            text-align: center;
        }

        .invFromTo {
            /* display: grid;   */
            grid-auto-flow: column;
            font-size: 10pt;
        }

        .invFrom {
            float: left;
            width: 60%;
            overflow-wrap: break-word;

        }

        .invTo {
            float: right;
            width: 40%;
            overflow-wrap: break-word;

        }

        .tdTitle {
            width: 130px;
            text-align: right;
        }

        .tdTitle2 {
            vertical-align: top;
        }

        .invToTable {
            margin-left: 10px;
            text-align: right;
        }

        .myBold {
            font-weight: bold
        }

        .invService {
            clear: both;
        }

        .invServiceTitle {
            text-decoration: underline;
            text-align: center;
            font-weight: bold;
        }

        .serviceTable {
            font-family: sans-serif;
            font-size: 10pt;
            border-collapse: collapse;
            width: 100%;
        }

        .serviceTableTH {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 2px;
            padding: 2px;
        }

        p {
            margin: 1px;
            padding: 1px;
        }

        .container {
            width: 80%;
            margin-right: auto;
            margin-left: auto;

        }

        .brand-section {
            background-color: #0d1033;
            padding: 5px 40px;
        }

        .logo {
            width: 50%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 40%;
            flex: 2 2 auto;
        }

        .text-white {
            color: #fff;
        }

        .company-details {
            float: right;
            text-align: right;
        }

        .body-section {
            padding: 10px;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 08px;
        }

        .sub-heading {
            color: #262626;
            margin-bottom: 0px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #111;
            background-color: #f2f2f2;
        }

        table td,
        table th {
            font-size: 15px;
            vertical-align: middle;
            text-align: center;
        }

        table th,
        table td {
            padding-top: 01px;
            padding-bottom: 01px;
        }

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-right {
            text-align: end;
        }

        .w-20 {
            width: 20%;
        }

        .w-10 {
            width: 10%;
        }

        .float-right {
            float: right;
        }

        .client-font-style {
            font-weight: bold;
            font-size: 15px;
        }

        .client-font-style2 {
            font-size: 14px;
        }

        .invoice-header {
            text-align: center;
            font-size: 17pt;
        }

        .client-info {
            max-width: 400px;
            text-align: left;
            border: 1px solid black;
        }

        .invoice-info {
            width: 100%;
            font-size: 14px;
            border-bottom: 1px;
            text-align: right;
            border: 1px solid black;
            display: inline-block;
            vertical-align: top;
        }

        .footerNote {
            text-align: right;
            font-size: 9px;
        }

        .tbTitle {
            text-align: right;
        }

        .addressDiv {}

        .footer {
            position: fixed;
            bottom: 5%;
            width: 100%;
        }
    </style>
</head>

@foreach ($final_arr as $row)


    <body style="margin-top: 80px">
        <div class="">
            <h3 class="invoice-header">INVOICE</h3>
            {{-- New Item --}}

            <div class="invFromTo">
                <div class="invFrom ">
                    <table>
                        <tr style="font-weight: bold;">
                            <td class="tdTitle">Customer ID:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->client_id }}</td>
                        </tr> <br>

                        <tr style="font-weight: bold;">
                            <td class="tdTitle" style="vertical-align: top">Customer Name:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->client_name }}</td>
                        </tr>

                        <tr>
                            <td class="tdTitle" style="vertical-align: top">Customer Address:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->client_address }}</td>
                        </tr> <br>

                        <tr>
                            <td class="tdTitle" style="vertical-align: top">Attention:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->invoice_contact_person }}</td>
                        </tr>

                        <tr>
                            <td class="tdTitle" style="vertical-align: top">Designation:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->contact_person_designation }}</td>
                        </tr>

                        <tr>
                            <td class="tdTitle" style="vertical-align: top">Contact:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->contact_person_phone }}</td>
                        </tr>

                        <tr>
                            <td class="tdTitle" style="vertical-align: top">Email:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->contact_person_email }}</td>
                        </tr>

                        <tr style="font-weight: bold">
                            <td class="tdTitle">Cust. BIN/VAT:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->client_bin_number }}</td>
                        </tr>

                        @if ($row['invoice_info']->client_po_number != null)
                        <tr style="font-weight: bold">
                            <td class="tdTitle">PO Number:</td>
                            <td style="text-align: left">{{ $row['invoice_info']->client_po_number }}</td>
                        </tr>
                        @endif
                        
                    </table>
                </div>

                <div class="invTo" style="margin-right: 20px">
                    <table class="invToTable">
                        <tr class="myBold">
                            <td style="text-align: right">Service Location:</td>
                            <td style="text-align: right">{{ $row['invoice_info']->service_location }}</td>
                        </tr> <br><br>

                        <tr class="myBold">
                            @if ($row['invoice_info']->invoice_for == 3)
                                <td style="text-align: right">BIN No:</td>
                                <td style="text-align: right">000479118-0208</td>
                            @else
                                <td style="text-align: right">Coloasia BIN No:</td>
                                <td style="text-align: right">000306099-0101</td>
                            @endif

                        </tr> <br>

                        <tr class="myBold">
                            <td style="text-align: right">Invoice No:</td>
                            <td style="text-align: right">
                                {{ $row['invoice_info']->invoice_month_year }}-{{ $row['invoice_info']->client_id }}-{{ $row['invoice_info']->in_id }}
                            </td>
                        </tr>

                        <tr>
                            <td class="myBold" style="text-align: right">Invoice Date:</td>
                            <td style="text-align: right">{{ $row['invoice_info']->invoice_date }}</td>
                        </tr>

                        <tr>
                            <td class="myBold" style="text-align: right">Due Date:</td>
                            <td style="text-align: right">{{ $row['invoice_info']->invoice_due_date }}</td>
                        </tr>

                        <tr>
                            <td class="myBold" style="text-align: right">From Date:</td>
                            <td style="text-align: right">{{ $row['invoice_info']->invoice_from_date }}</td>
                        </tr>

                        <tr>
                            <td class="myBold" style="text-align: right">To Date:</td>
                            <td style="text-align: right">{{ $row['invoice_info']->invoice_to_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <div class="body-section" style="clear: both">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="">Service Name</th>
                                <th class="w-10">Quantity</th>
                                <th class="w-20">Unit Price (BDT)</th>
                                <th class="w-20">Total Price (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row['services'] as $srow)
                                @if ($srow->available_till >= $row['invoice_info']->invoice_from_date)
                                    @if ($srow->cat <= $row['invoice_info']->iat)
                                        @if ($srow->status == 'y')
                                            <tr>
                                                <td style="text-align: center">{{ $srow->service_name }}
                                                    {{-- @if ($srow->available_from > $row['invoice_info']->invoice_from_date)
                                                        [{{ $srow->available_from }} to {{ $srow->available_till }}]
                                                    @elseif ($srow->available_till < $row['invoice_info']->invoice_to_date)
                                                        [{{ $srow->available_from }} to {{ $srow->available_till }}]
                                                    @endif --}}

                                                    @if (($srow->available_from >= $row['invoice_info']->invoice_from_date) && ($srow->available_till <= $row['invoice_info']->invoice_to_date))
                                                        [{{ $srow->available_from }} to {{ $srow->available_till }}]
                                                    @elseif(($srow->available_from > $row['invoice_info']->invoice_from_date) && ($srow->available_till >= $row['invoice_info']->invoice_to_date))
                                                        [{{ $srow->available_from }} to {{ $row['invoice_info']->invoice_to_date }}]
                                                    @elseif(($srow->available_from <= $row['invoice_info']->invoice_from_date) && ($srow->available_till <= $row['invoice_info']->invoice_to_date))
                                                        [{{ $row['invoice_info']->invoice_from_date }} to {{ $srow->available_till }}]
                                                    @endif
                                                </td>
                                                <td style="text-align: center">{{ $srow->quantity }}</td>
                                                <td style="text-align: right">
                                                    @php
                                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                                        echo $formatter->format($srow->unit_price);
                                                    @endphp
                                                </td>
                                                <td style="text-align: right">
                                                    @php
                                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                                        // echo $formatter->format($srow->unit_price * $srow->quantity);
                                                        $totalMonthlyDays = strtotime($row['invoice_info']->invoice_to_date) - strtotime($row['invoice_info']->invoice_from_date);
                                                        $convertMonthlyDays = $totalMonthlyDays / (24 * 60 * 60) + 1;
                                                        if ($srow->available_from >= $row['invoice_info']->invoice_from_date && $srow->available_till <= $row['invoice_info']->invoice_to_date) {
                                                            $splitDays3 = strtotime($srow->available_till) - strtotime($srow->available_from);
                                                            $con = $splitDays3 / (24 * 60 * 60) + 1;
                                                            echo $formatter->format((($srow->unit_price * $srow->quantity) / $convertMonthlyDays) * $con);
                                                        } elseif ($srow->available_from > $row['invoice_info']->invoice_from_date) {
                                                            $splitDays1 = strtotime($row['invoice_info']->invoice_to_date) - strtotime($srow->available_from);
                                                            $con = $splitDays1 / (24 * 60 * 60) + 1;
                                                            echo $formatter->format((($srow->unit_price * $srow->quantity) / $convertMonthlyDays) * $con);
                                                        } elseif ($srow->available_till < $row['invoice_info']->invoice_to_date) {
                                                            $splitDays2 = strtotime($srow->available_till) - strtotime($row['invoice_info']->invoice_from_date);
                                                            $con = $splitDays2 / (24 * 60 * 60) + 1;
                                                            echo $formatter->format((($srow->unit_price * $srow->quantity) / $convertMonthlyDays) * $con);
                                                        } else {
                                                            echo $formatter->format($srow->unit_price * $srow->quantity);
                                                        }
                                                    @endphp
                                                </td>
                                            </tr>
                                        @elseif ($srow->status == 'n')
                                            @if ($srow->uat >= $row['invoice_info']->iat)
                                                <tr>
                                                    <td style="text-align: center">
                                                        {{ $srow->service_name }}
                                                        @if ($srow->available_from > $row['invoice_info']->invoice_from_date)
                                                            [{{ $srow->available_from }} to
                                                            {{ $srow->available_till }}]
                                                        @endif

                                                    </td>
                                                    <td style="text-align: center">{{ $srow->quantity }}</td>

                                                    <td style="text-align: right">
                                                        @php
                                                            $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                                            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                                            echo $formatter->format($srow->unit_price);
                                                        @endphp
                                                    </td>
                                                    <td style="text-align: right">
                                                        @php
                                                            $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                                            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                                            echo $formatter->format($srow->unit_price * $srow->quantity);
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach

                            <tr>
                                <td colspan="3" class="text-right tbTitle">Sub Total in BDT [Excluding
                                    VAT]</td>
                                <td style="text-align: right">
                                    @php
                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                        echo $formatter->format($row['invoice_info']->sub_total);
                                    @endphp
                                </td>
                            </tr>
                            @if ($row['invoice_info']->arrearsTitle != null)
                                <tr>
                                    <td colspan="3" class="text-right tbTitle">
                                      Arrear:  {{ $row['invoice_info']->arrearsTitle }}</td>
                                        
                                    <td style="text-align: right">
                                        @php
                                        echo $formatter->format($row['invoice_info']->arrearsAmount)
                                            
                                        @endphp
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-right tbTitle">
                                        Sub Total in BDT with Arrear [Excluding VAT]</td>
                                        
                                    <td style="text-align: right">
                                        @php
                                        echo $formatter->format($row['invoice_info']->sub_total + $row['invoice_info']->arrearsAmount)
                                            
                                        @endphp
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                {{-- <td colspan="3" class="text-right tbTitle">VAT ( @php echo ($row['invoice_info']->client_vat) @endphp % )</td> --}}
                                <td colspan="3" class="text-right tbTitle">VAT
                                    @if ($row['invoice_info']->client_vat == 0)
                                        @php echo("( )") @endphp
                                    @else
                                        ( @php echo ($row['invoice_info']->client_vat) @endphp % )
                                    @endif
                                </td>
                                @if ($row['invoice_info']->arrearsTitle != null)

                                <td style="text-align: right">
                                    @php
                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                        echo $formatter->format(($row['invoice_info']->client_vat / 100) * ($row['invoice_info']->sub_total + $row['invoice_info']->arrearsAmount));
                                    @endphp
                                </td>
                                    
                                @else
                                <td style="text-align: right">
                                    @php
                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                        echo $formatter->format(($row['invoice_info']->client_vat / 100) * $row['invoice_info']->sub_total);
                                    @endphp
                                </td>

                                @endif
                            </tr>

                            

                            <tr>
                                <td colspan="3" class="text-right tbTitle">Total Invoice Amount
                                </td>
                                <td style="text-align: right">
                                    @php
                                        $formatter = new NumberFormatter('en_GB', NumberFormatter::CURRENCY);
                                        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
                                        echo $formatter->format($row['invoice_info']->total_amount);
                                    @endphp
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    @php
                        $moneyInWord = App\Http\Controllers\InvoiceIndexController::getBangladeshCurrency($row['invoice_info']->total_amount);
                        
                    @endphp

                    <p><span class="client-font-style" style="text-transform: capitalize">In words:
                            {{-- @php
                            $inWord = new NumberFormatter('en_GB', NumberFormatter::CURRENCY_CODE);
                            echo $inWord->format($row['invoice_info']->total_amount);
                        @endphp --}}
                            @php
                                echo $moneyInWord;
                            @endphp
                            only
                        </span></p> <br>
                    <p><span class="client-font-style" style="text-decoration: underline; font-size:10pt">Payment
                            Instruction:</span></p>
                    <p style="font-size: 10pt">Payment should be made by A/C payee cheque or direct deposit to A/C of
                        @if ($row['invoice_info']->invoice_for == 3)
                            <span class="client-font-style" style="font-size: 10pt">BANGLA TELECOM LIMITED.</span>
                        @else
                            <span class="client-font-style" style="font-size: 10pt">COLOASIA LIMITED.</span>
                        @endif
                    </p> <br>

                    <div style="width: 40%">
                        <table>
                            <tr>
                                <td style="text-align: right; font-size: 10pt">Account Title:</td>
                                @if ($row['invoice_info']->invoice_for == 3)
                                    <td style="text-align: left; font-weight:bold; font-size: 10pt"> &nbsp; Bangla
                                        Telecom Limited
                                    </td>
                                @else
                                    <td style="text-align: left; font-weight:bold; font-size: 10pt"> &nbsp; Coloasia
                                        Limited
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td style="text-align: right; font-size: 10pt">Account No:</td>

                                @if ($row['invoice_info']->invoice_for == 3)
                                    <td style="text-align: left; font-weight:bold; font-size: 10pt"> &nbsp; 3555 10200
                                        2487
                                    </td>
                                @else
                                    <td style="text-align: left; font-weight:bold; font-size: 10pt"> &nbsp; 3555 10200
                                        2523
                                    </td>
                                @endif

                            </tr>
                            <tr>
                                <td style="text-align: right; font-size: 10pt">Bank Name:</td>
                                <td style="text-align: left; font-size: 10pt"> &nbsp; Pubali Bank Limited</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; font-size: 10pt">Branch:</td>
                                <td style="text-align: left; font-size: 10pt"> &nbsp; Principal Branch</td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <footer class="footer" style="clear: both;">
                        <div style="margin-left: 160px">
                            <h5>This is system generated invoice and no signature is required</h5>
                        </div>
                        <div class="footerNote" style="margin-right: 20px">
                            <p class="">*contact with the invoice sender regarding any mismatch</p>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </body>
@endforeach

</html>
