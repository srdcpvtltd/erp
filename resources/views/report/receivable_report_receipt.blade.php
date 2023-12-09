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

    <title>{{ env('APP_NAME') }} - Receivable Report</title>
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
        <div class="row">
            <div class="col-12" id="invoice-container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tab-content" id="myTabContent2">
                                    @if ($reportName == '#customer_balance')
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th width="33%"> {{ __('Customer Name') }}</th>
                                                    <th width="33%"> {{ __('Invoice Balance') }}</th>
                                                    <th width="33%"> {{ __('Available Credits') }}</th>
                                                    <th class="text-end"> {{ __('Balance') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $mergedArray = [];

                                                    foreach ($receivableCustomers as $item) {
                                                        $name = $item['name'];

                                                        if (!isset($mergedArray[$name])) {
                                                            $mergedArray[$name] = [
                                                                'name' => $name,
                                                                'price' => 0.0,
                                                                'pay_price' => 0.0,
                                                                'total_tax' => 0.0,
                                                                'credit_price' => 0.0,
                                                            ];
                                                        }

                                                        $mergedArray[$name]['price'] += floatval($item['price']);
                                                        if ($item['pay_price'] !== null) {
                                                            $mergedArray[$name]['pay_price'] += floatval($item['pay_price']);
                                                        }
                                                        $mergedArray[$name]['total_tax'] += floatval($item['total_tax']);
                                                        $mergedArray[$name]['credit_price'] += floatval($item['credit_price']);
                                                    }
                                                    $resultArray = array_values($mergedArray);
                                                    $total = 0;
                                                @endphp
                                                @foreach ($resultArray as $receivableCustomer)
                                                    <tr>
                                                        @php
                                                            $customerBalance = $receivableCustomer['price'] + $receivableCustomer['total_tax'] - $receivableCustomer['pay_price'];
                                                            $balance = $customerBalance - $receivableCustomer['credit_price'];
                                                            $total += $balance;
                                                        @endphp
                                                        <td> {{ $receivableCustomer['name'] }}</td>
                                                        <td> {{ \Auth::user()->priceFormat($customerBalance) }} </td>
                                                        <td> {{ !empty($receivableCustomer['credit_price']) ? \Auth::user()->priceFormat($receivableCustomer['credit_price']) : \Auth::user()->priceFormat(0) }}
                                                        </td>
                                                        <td class="text-end">
                                                            {{ \Auth::user()->priceFormat($balance) }} </td>
                                                    </tr>
                                                @endforeach
                                                @if ($receivableCustomers != [])
                                                    <tr>
                                                        <th>{{ __('Total') }}</th>
                                                        <td></td>
                                                        <td></td>
                                                        <th class="text-end">{{ \Auth::user()->priceFormat($total) }}
                                                        </th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @elseif ($reportName == '#receivable_summary')
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Customer Name') }}</th>
                                                    <th>{{ __('Date') }}</th>
                                                    <th>{{ __('Transaction') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Transaction Type') }}</th>
                                                    <th>{{ __('Total') }}</th>
                                                    <th>{{ __('Balance') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total = 0;
                                                    $totalAmount = 0;

                                                    function compare($a, $b)
                                                    {
                                                        return strtotime($b['issue_date']) - strtotime($a['issue_date']);
                                                    }
                                                    usort($receivableSummaries, 'compare');
                                                @endphp
                                                @foreach ($receivableSummaries as $receivableSummary)
                                                    <tr>
                                                        @php
                                                            if ($receivableSummary['invoice']) {
                                                                $receivableBalance = $receivableSummary['price'] + $receivableSummary['total_tax'];
                                                            } else {
                                                                $receivableBalance = -$receivableSummary['price'];
                                                            }
                                                            $pay_price = $receivableSummary['pay_price'] != null ? $receivableSummary['pay_price'] : 0;
                                                            $balance = $receivableBalance - $pay_price;
                                                            $total += $balance;
                                                            $totalAmount += $receivableBalance;
                                                        @endphp
                                                        <td> {{ $receivableSummary['name'] }}</td>
                                                        <td> {{ $receivableSummary['issue_date'] }}</td>
                                                        @if ($receivableSummary['invoice'])
                                                            <td> {{ \Auth::user()->invoiceNumberFormat($receivableSummary['invoice']) }}
                                                            @else
                                                            <td>{{ __('Credit Note') }}</td>
                                                        @endif
                                                        </td>
                                                        <td>
                                                            @if ($receivableSummary['status'] == 0)
                                                                <span
                                                                    class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableSummary['status']]) }}</span>
                                                            @elseif($receivableSummary['status'] == 1)
                                                                <span
                                                                    class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableSummary['status']]) }}</span>
                                                            @elseif($receivableSummary['status'] == 2)
                                                                <span
                                                                    class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableSummary['status']]) }}</span>
                                                            @elseif($receivableSummary['status'] == 3)
                                                                <span
                                                                    class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableSummary['status']]) }}</span>
                                                            @elseif($receivableSummary['status'] == 4)
                                                                <span
                                                                    class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableSummary['status']]) }}</span>
                                                            @else
                                                                <span class="p-2 px-3">-</span>
                                                            @endif
                                                        </td>
                                                        @if ($receivableSummary['invoice'])
                                                            <td> {{ __('Invoice') }}
                                                            @else
                                                            <td>{{ __('Credit Note') }}</td>
                                                        @endif
                                                        <td> {{ \Auth::user()->priceFormat($receivableBalance) }} </td>

                                                        <td> {{ \Auth::user()->priceFormat($balance) }} </td>

                                                        {{-- <td> {{ !empty($receivableCustomer['credit_price']) ? \Auth::user()->priceFormat($receivableCustomer['credit_price']) : \Auth::user()->priceFormat(0) }} --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if ($receivableSummaries != [])
                                                    <tr>
                                                        <th>{{ __('Total') }}</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>{{ \Auth::user()->priceFormat($totalAmount) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($total) }}</th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @elseif ($reportName == '#receivable_details')
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Customer Name') }}</th>
                                                    <th>{{ __('Date') }}</th>
                                                    <th>{{ __('Transaction') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Transaction Type') }}</th>
                                                    <th>{{ __('Item Name') }}</th>
                                                    <th>{{ __('Quantity Ordered') }}</th>
                                                    <th>{{ __('Item Price') }}</th>
                                                    <th>{{ __('Total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total = 0;
                                                    $totalQuantity = 0;

                                                    function compares($a, $b)
                                                    {
                                                        return strtotime($b['issue_date']) - strtotime($a['issue_date']);
                                                    }
                                                    usort($receivableDetails, 'compares');
                                                @endphp
                                                @foreach ($receivableDetails as $receivableDetail)
                                                    <tr>
                                                        @php
                                                            if ($receivableDetail['invoice']) {
                                                                $receivableBalance = $receivableDetail['price'];
                                                            } else {
                                                                $receivableBalance = -$receivableDetail['price'];
                                                            }
                                                            if ($receivableDetail['invoice']) {
                                                                $quantity = $receivableDetail['quantity'];
                                                            } else {
                                                                $quantity = 0;
                                                            }

                                                            if ($receivableDetail['invoice']) {
                                                                $itemTotal = $receivableBalance * $receivableDetail['quantity'];
                                                            } else {
                                                                $itemTotal = -$receivableDetail['price'];
                                                            }

                                                            $total += $itemTotal;
                                                            $totalQuantity += $quantity;
                                                        @endphp
                                                        <td> {{ $receivableDetail['name'] }}</td>
                                                        <td> {{ $receivableDetail['issue_date'] }}</td>
                                                        @if ($receivableDetail['invoice'])
                                                            <td> {{ \Auth::user()->invoiceNumberFormat($receivableDetail['invoice']) }}
                                                            </td>
                                                        @else
                                                            <td>{{ __('Credit Note') }}</td>
                                                        @endif
                                                        </td>
                                                        <td>
                                                            @if ($receivableDetail['status'] == 0)
                                                                <span
                                                                    class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableDetail['status']]) }}</span>
                                                            @elseif($receivableDetail['status'] == 1)
                                                                <span
                                                                    class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableDetail['status']]) }}</span>
                                                            @elseif($receivableDetail['status'] == 2)
                                                                <span
                                                                    class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableDetail['status']]) }}</span>
                                                            @elseif($receivableDetail['status'] == 3)
                                                                <span
                                                                    class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableDetail['status']]) }}</span>
                                                            @elseif($receivableDetail['status'] == 4)
                                                                <span
                                                                    class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$receivableDetail['status']]) }}</span>
                                                            @else
                                                                <span class="p-2 px-3">-</span>
                                                            @endif
                                                        </td>
                                                        @if ($receivableDetail['invoice'])
                                                            <td> {{ __('Invoice') }}</td>
                                                        @else
                                                            <td>{{ __('Credit Note') }}</td>
                                                        @endif
                                                        <td>{{ $receivableDetail['product_name'] }}</td>
                                                        <td> {{ $quantity }}</td>
                                                        <td>{{ \Auth::user()->priceFormat($receivableBalance) }}</td>
                                                        <td>{{ \Auth::user()->priceFormat($itemTotal) }}</td>

                                                    </tr>
                                                @endforeach
                                                @if ($receivableSummaries != [])
                                                    <tr>
                                                        <th>{{ __('Total') }}</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>{{ $totalQuantity }}</th>
                                                        <th></th>
                                                        <th>{{ \Auth::user()->priceFormat($total) }}</th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @elseif($reportName == '#aging_summary')
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Customer Name') }}</th>
                                                    <th>{{ __('Current') }}</th>
                                                    <th>{{ __('1-15 DAYS') }}</th>
                                                    <th>{{ __('16-30 DAYS') }}</th>
                                                    <th>{{ __('31-45 DAYS') }}</th>
                                                    <th>{{ __('> 45 DAYS') }}</th>
                                                    <th>{{ __('Total') }}</th>
                                                </tr>
                                            </thead>



                                            <tbody>
                                                @php
                                                    $currentTotal = 0;
                                                    $days15 = 0;
                                                    $days30 = 0;
                                                    $days45 = 0;
                                                    $daysMore45 = 0;
                                                    $total = 0;

                                                @endphp
                                                @foreach ($agingSummaries as $key => $agingSummary)
                                                    <tr>
                                                        <td> {{ $key }}</td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['current']) }}
                                                        </td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['1_15_days']) }}
                                                        </td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['16_30_days']) }}
                                                        </td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['31_45_days']) }}
                                                        </td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['greater_than_45_days']) }}
                                                        </td>
                                                        <td>{{ \Auth::user()->priceFormat($agingSummary['total_due']) }}
                                                        </td>
                                                    </tr>

                                                    @php
                                                        $currentTotal += $agingSummary['current'];
                                                        $days15 += $agingSummary['1_15_days'];
                                                        $days30 += $agingSummary['16_30_days'];
                                                        $days45 += $agingSummary['31_45_days'];
                                                        $daysMore45 += $agingSummary['greater_than_45_days'];
                                                        $total += $agingSummary['total_due'];

                                                    @endphp
                                                @endforeach
                                                @if ($agingSummaries != [])
                                                    <tr>
                                                        <th>{{ __('Total') }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($currentTotal) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($days15) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($days30) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($days45) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($daysMore45) }}</th>
                                                        <th>{{ \Auth::user()->priceFormat($total) }}</th>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @elseif($reportName == '#aging_details')
                                    <table class="table table-flush" id="report-dataTable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Transaction') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Customer Name') }}</th>
                                                <th>{{ __('Age') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Balance Due') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $currentTotal = 0;
                                                $currentDue = 0;
                                                $days15Total = 0;
                                                $days15Due = 0;

                                                $days30Total = 0;
                                                $days30Due = 0;

                                                $days45Total = 0;
                                                $days45Due = 0;

                                                $daysMore45Total = 0;
                                                $daysMore45Due = 0;

                                                $total = 0;
                                            @endphp
                                            @if ($moreThan45 != [])
                                                <tr>
                                                    <th>{{ __(' > 45 Days') }}</th>
                                                </tr>
                                            @endif
                                            @foreach ($moreThan45 as $value)
                                                @php
                                                    $daysMore45Total += $value['total_price'];
                                                    $daysMore45Due += $value['balance_due'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $value['due_date'] }}</td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($value['invoice_id']) }}
                                                    </td>
                                                    <td>{{ __('Invoice') }}</td>
                                                    <td>
                                                        @if ($value['status'] == 0)
                                                            <span
                                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$value['status']]) }}</span>
                                                        @elseif($value['status'] == 1)
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$value['status']]) }}</span>
                                                        @elseif($value['status'] == 2)
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$value['status']]) }}</span>
                                                        @elseif($value['status'] == 3)
                                                            <span
                                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$value['status']]) }}</span>
                                                        @elseif($value['status'] == 4)
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$value['status']]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $value['name'] }}</td>
                                                    <td> {{ $value['age'] . __(' Days') }} </td>
                                                    <td>{{ \Auth::user()->priceFormat($value['total_price']) }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($value['balance_due']) }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($moreThan45 != [])
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ \Auth::user()->priceFormat($daysMore45Total) }}</th>
                                                    <th>{{ \Auth::user()->priceFormat($daysMore45Due) }}</th>
                                                </tr>
                                            @endif


                                            @if ($days31to45 != [])
                                                <tr>
                                                    <th>{{ __(' 31 to 45 Days') }}</th>
                                                </tr>
                                            @endif
                                            @foreach ($days31to45 as $day31to45)
                                                @php
                                                    $days45Total += $day31to45['total_price'];
                                                    $days45Due += $day31to45['balance_due'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $day31to45['due_date'] }}</td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($day31to45['invoice_id']) }}
                                                    </td>
                                                    <td>{{ __('Invoice') }}</td>
                                                    <td>
                                                        @if ($day31to45['status'] == 0)
                                                            <span
                                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day31to45['status']]) }}</span>
                                                        @elseif($day31to45['status'] == 1)
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day31to45['status']]) }}</span>
                                                        @elseif($day31to45['status'] == 2)
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day31to45['status']]) }}</span>
                                                        @elseif($day31to45['status'] == 3)
                                                            <span
                                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day31to45['status']]) }}</span>
                                                        @elseif($day31to45['status'] == 4)
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day31to45['status']]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $day31to45['name'] }}</td>
                                                    <td> {{ $day31to45['age'] . __(' Days') }} </td>
                                                    <td>{{ \Auth::user()->priceFormat($day31to45['total_price']) }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($day31to45['balance_due']) }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($days31to45 != [])
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ \Auth::user()->priceFormat($days45Total) }}</th>
                                                    <th>{{ \Auth::user()->priceFormat($days45Due) }}</th>
                                                </tr>
                                            @endif

                                            @if ($days16to30 != [])
                                                <tr>
                                                    <th>{{ __(' 16 to 30 Days') }}</th>
                                                </tr>
                                            @endif
                                            @foreach ($days16to30 as $day16to30)
                                                @php
                                                    $days30Total += $day16to30['total_price'];
                                                    $days30Due += $day16to30['balance_due'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $day16to30['due_date'] }}</td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($day16to30['invoice_id']) }}
                                                    </td>
                                                    <td>{{ __('Invoice') }}</td>
                                                    <td>
                                                        @if ($day16to30['status'] == 0)
                                                            <span
                                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day16to30['status']]) }}</span>
                                                        @elseif($day16to30['status'] == 1)
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day16to30['status']]) }}</span>
                                                        @elseif($day16to30['status'] == 2)
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day16to30['status']]) }}</span>
                                                        @elseif($day16to30['status'] == 3)
                                                            <span
                                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day16to30['status']]) }}</span>
                                                        @elseif($day16to30['status'] == 4)
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day16to30['status']]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $day16to30['name'] }}</td>
                                                    <td> {{ $day16to30['age'] . __(' Days') }} </td>
                                                    <td>{{ \Auth::user()->priceFormat($day16to30['total_price']) }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($day16to30['balance_due']) }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($days16to30 != [])
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ \Auth::user()->priceFormat($days30Total) }}</th>
                                                    <th>{{ \Auth::user()->priceFormat($days30Due) }}</th>
                                                </tr>
                                            @endif

                                            @if ($days1to15 != [])
                                                <tr>
                                                    <th>{{ __(' 1 to 15 Days') }}</th>
                                                </tr>
                                            @endif
                                            @foreach ($days1to15 as $day1to15)
                                                @php
                                                    $days15Total += $day1to15['total_price'];
                                                    $days15Due += $day1to15['balance_due'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $day1to15['due_date'] }}</td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($day1to15['invoice_id']) }}
                                                    </td>
                                                    <td>{{ __('Invoice') }}</td>
                                                    <td>
                                                        @if ($day1to15['status'] == 0)
                                                            <span
                                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day1to15['status']]) }}</span>
                                                        @elseif($day1to15['status'] == 1)
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day1to15['status']]) }}</span>
                                                        @elseif($day1to15['status'] == 2)
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day1to15['status']]) }}</span>
                                                        @elseif($day1to15['status'] == 3)
                                                            <span
                                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day1to15['status']]) }}</span>
                                                        @elseif($day1to15['status'] == 4)
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$day1to15['status']]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $day1to15['name'] }}</td>
                                                    <td> {{ $day1to15['age'] . __(' Days') }} </td>
                                                    <td>{{ \Auth::user()->priceFormat($day1to15['total_price']) }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($day1to15['balance_due']) }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($days1to15 != [])
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ \Auth::user()->priceFormat($days15Total) }}</th>
                                                    <th>{{ \Auth::user()->priceFormat($days15Due) }}</th>
                                                </tr>
                                            @endif

                                            @if ($currents != [])
                                                <tr>
                                                    <th>{{ __('Current') }}</th>
                                                </tr>
                                            @endif
                                            @foreach ($currents as $current)
                                                @php
                                                    $currentTotal += $current['total_price'];
                                                    $currentDue += $current['balance_due'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $current['due_date'] }}</td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($current['invoice_id']) }}
                                                    </td>
                                                    <td>{{ __('Invoice') }}</td>
                                                    <td>
                                                        @if ($current['status'] == 0)
                                                            <span
                                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$current['status']]) }}</span>
                                                        @elseif($current['status'] == 1)
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$current['status']]) }}</span>
                                                        @elseif($current['status'] == 2)
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$current['status']]) }}</span>
                                                        @elseif($current['status'] == 3)
                                                            <span
                                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$current['status']]) }}</span>
                                                        @elseif($current['status'] == 4)
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$current['status']]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $current['name'] }}</td>
                                                    <td> - </td>
                                                    <td>{{ \Auth::user()->priceFormat($current['total_price']) }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($current['balance_due']) }}</td>
                                                </tr>
                                            @endforeach
                                            @if ($currents != [])
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ \Auth::user()->priceFormat($currentTotal) }}</th>
                                                    <th>{{ \Auth::user()->priceFormat($currentDue) }}</th>
                                                </tr>
                                            @endif
                                            @if ($currents != [] || $days1to15 != [] || $days16to30 != [] || $days31to45 != [] || $moreThan45 != []) 
                                            <tr>
                                                <th>{{ __('Total') }}</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>{{ \Auth::user()->priceFormat($currentTotal + $days15Total + $days30Total + $days45Total + $daysMore45Total) }}
                                                </th>
                                                <th>{{ \Auth::user()->priceFormat($currentDue + $days15Due + $days30Due + $days45Due + $daysMore45Due) }}
                                                </th>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
