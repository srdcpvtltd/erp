{{-- @extends('layouts.admin') --}}
@php
    $settings = Utility::settings();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
@endphp
<html lang="en" dir="{{$settings == 'on'?'rtl':''}}">
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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" >

    <title>{{env('APP_NAME')}} - Balance Sheet</title>
    @if (isset($settings['SITE_RTL'] ) && $settings['SITE_RTL'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css')}}" id="main-style-link">
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
                        <div class="account-main-title mb-5">
                            <h5>{{ 'Balance Sheet of ' . $user->name . ' as of ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}
                                </h4>
                        </div>
                        <div
                            class="aacount-title d-flex align-items-center justify-content-between border-top border-bottom py-2">
                            <h6 class="mb-0">{{ __('Account') }}</h6>
                            <h6 class="mb-0 text-center">{{ _('Account Code') }}</h6>
                            <h6 class="mb-0 text-end">{{ __('Total') }}</h6>
                        </div>

                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach ($chartAccounts as $type => $accounts)
                            @if ($accounts != [])
                                <div class="account-main-inner py-2">
                                    @if ($type == 'Liabilities')
                                        <p class="fw-bold mb-3"> {{ __('Liabilities & Equity') }}</p>
                                    @endif
                                    <p class="fw-bold ps-2 mb-2">{{ $type }}</p>

                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($accounts as $account)
                                        <div class="border-bottom py-2">
                                            <p class="fw-bold ps-4 mb-2">
                                                {{ $account['subType'] == true ? $account['subType'] : '' }}</p>
                                            @foreach ($account['account'] as $key => $record)
                                                @if ($key < count($account['account']) - 1)
                                                    @if (!preg_match('/\btotal\b/i', $record['account_name']))
                                                        <div
                                                            class="account-inner d-flex align-items-center justify-content-between ps-5">
                                                            <p class="mb-2"><a
                                                                    href="{{ route('report.ledger',  $record['account_id']) }}?account={{  $record['account_id'] }}"
                                                                    class="text-primary">{{ $record['account_name'] }}</a>
                                                            </p>
                                                            <p class="mb-2 text-center">{{ $record['account_code'] }}</p>
                                                            <p class="text-primary mb-2 float-end text-end">
                                                                {{ $record['netAmount'] }}</p>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <div
                                                class="account-inner d-flex align-items-center justify-content-between ps-4">
                                                <p class="fw-bold mb-2">
                                                    {{ end($account['account']) == true ? end($account['account'])['account_name'] : 0 }}
                                                </p>
                                                <p class="fw-bold mb-2 text-end">
                                                    {{ end($account['account']) == true ? end($account['account'])['netAmount'] : 0 }}
                                                </p>
                                            </div>
                                        </div>

                                        @php
                                            $total += end($account['account']) == true ? end($account['account'])['netAmount'] : 0;
                                        @endphp
                                    @endforeach
                                    <div
                                        class="aacount-title d-flex align-items-center justify-content-between border-top border-bottom py-2 px-2 pe-0">
                                        <h6 class="fw-bold mb-0">{{ 'Total for ' . $type }}</h6>
                                        <h6 class="fw-bold mb-0 text-end">{{ $total }}</h6>
                                    </div>
                                    @php
                                        if ($type != 'Assets') {
                                            $totalAmount += $total;
                                        }
                                    @endphp
                                </div>
                            @endif
                        @endforeach

                        @foreach ($chartAccounts as $type => $accounts)
                            @php
                                if ($type == 'Assets') {
                                    continue;
                                }
                            @endphp

                            @if ($accounts != [])
                                <div
                                    class="aacount-title d-flex align-items-center justify-content-between border-bottom py-2 px-0">
                                    <h6 class="fw-bold mb-0">{{ 'Total for Liabilities & Equity' }}</h6>
                                    <h6 class="fw-bold mb-0 text-end">{{ $totalAmount }}</h6>
                                </div>
                            @endif

                            @php
                                if ($type == 'Liabilities' || $type == 'Equity') {
                                    break;
                                }
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

