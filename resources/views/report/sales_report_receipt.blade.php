{{-- @extends('layouts.admin') --}}
@php
    $settings = Utility::settings();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
@endphp
<html lang="en" dir="{{ $settings == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <title>{{ env('APP_NAME') }} - Sales Report</title>
    @if (isset($settings['SITE_RTL']) && $settings['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif


</head>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script>
    var filename = $('#filename').val();

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: filename,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A2'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#filter").click(function() {
            $("#show_filter").toggle();
        });
    });
</script>

<script>
    window.print();
    window.onafterprint = back;

    function back() {
        window.close();
        window.history.back();
    }
</script>

<body class="{{ $color }}">
    <div class="mt-4">
        @php
            $authUser = \Auth::user()->creatorId();
            $user = App\Models\User::find($authUser);
        @endphp
        <div class="row justify-content-center" id="printableArea">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if ($reportName == '#item')
                            <div class="account-main-title mb-5">
                                <h5>{{ 'Sales By Item of' . $user->name . ' as of ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}
                                </h5>
                                <table class="table table-flush mt-3" id="report-dataTable">
                                    <thead>
                                        <tr>
                                            <th width="33%"> {{__('Invoice Item')}}</th>
                                            <th width="33%"> {{__('Quantity Sold')}}</th>
                                            <th width="33%"> {{__('Amount')}}</th>
                                            <th class="text-end"> {{__('Average Price')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoiceItems as $invoiceItem)
                                            <tr>
                                                <td>{{ $invoiceItem['name'] }}</td>
                                                <td>{{ $invoiceItem['quantity'] }}</td>
                                                <td>{{ \Auth::user()->priceFormat($invoiceItem['price']) }}</td>
                                                <td>{{ \Auth::user()->priceFormat($invoiceItem['avg_price']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="account-main-title mb-5">
                                <h5>{{ 'Sales By Customer of' . $user->name . ' as of ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}
                                </h5>
                                <table class="table table-flush mt-3" id="report-dataTable">
                                    <thead>
                                        <tr>
                                            <th width="33%"> {{__('Customer Name')}}</th>
                                            <th width="33%"> {{__('Invoice Count')}}</th>
                                            <th width="33%"> {{__('Sales')}}</th>
                                            <th class="text-end"> {{__('Sales With Tax')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoiceCustomers as $invoiceCustomer)
                                            <tr>
                                                <td>{{ $invoiceCustomer['name'] }}</td>
                                                <td>{{ $invoiceCustomer['invoice_count'] }}</td>
                                                <td>{{ \Auth::user()->priceFormat($invoiceCustomer['price']) }}</td>
                                                <td>{{ \Auth::user()->priceFormat($invoiceCustomer['price'] + $invoiceCustomer['total_tax']) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
