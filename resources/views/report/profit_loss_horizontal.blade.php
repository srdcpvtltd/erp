@extends('layouts.admin')
@section('page-title')
    {{ __('Profit & Loss') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Profit & Loss') }}</li>
@endsection


@push('script-page')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#filter").click(function() {
                $("#show_filter").toggle();
            });
        });
    </script>
@endpush
@section('action-btn')
    {{-- <div class="float-end">
        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"data-bs-toggle="tooltip"
            title="{{ __('Download') }}" data-original-title="{{ __('Download') }}">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>
    </div> --}}

    <div class="float-end">
        {{ Form::open(['route' => ['profit.loss.print' , 'horizontal']]) }}
        <input type="hidden" name="start_date" class="start_date">
        <input type="hidden" name="end_date" class="end_date">
        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Print') }}"
            data-original-title="{{ __('Print') }}"><i class="ti ti-printer"></i></button>
        {{ Form::close() }}
    </div>

    <div class="float-end me-2">
        {{ Form::open(['route' => ['profit.loss.export']]) }}
        <input type="hidden" name="start_date" class="start_date">
        <input type="hidden" name="end_date" class="end_date">
        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export') }}"
            data-original-title="{{ __('Export') }}"><i class="ti ti-file-export"></i></button>
        {{ Form::close() }}
    </div>

    <div class="float-end me-2" id="filter">
        <button id="filter" class="btn btn-sm btn-primary"><i class="ti ti-filter"></i></button>
    </div>

    <div class="float-end me-2">
        <a href="{{ route('report.profit.loss', 'vertical') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Verical View') }}" data-original-title="{{ __('Verical View') }}"><i
                class="ti ti-separator-horizontal"></i></a>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card" id="show_filter" style="display:none;">
                    <div class="card-body">
                        {{ Form::open(['route' => ['report.profit.loss'], 'method' => 'GET', 'id' => 'report_trial_balance']) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('start_date', $filter['startDateRange'], ['class' => 'startDate form-control']) }}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('end_date', $filter['endDateRange'], ['class' => 'endDate form-control']) }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="view" value="horizontal">

                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('report_trial_balance').submit(); return false;"
                                            data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                            data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{ route('trial.balance') }}" class="btn btn-sm btn-danger "
                                            data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                            data-original-title="{{ __('Reset') }}">
                                            <span class="btn-inner--icon"><i
                                                    class="ti ti-trash-off text-white-off "></i></span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    @php
        $authUser = \Auth::user()->creatorId();
        $user = App\Models\User::find($authUser);
    @endphp

    <div class="row justify-content-center" id="printableArea">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="account-main-title mb-5">
                        <h5>{{ 'Profit & Loss ' . $user->name . ' as of ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}
                            </h4>
                    </div>

                    @php
                        $totalIncome = 0;
                        $netProfit = 0;
                        $totalCosts = 0;
                        $grossProfit = 0;
                    @endphp

                    <div class="row">
                        <div class="col-md-6">
                            <div class="aacount-title d-flex align-items-center justify-content-between border py-2">
                                <h5 class="mb-0 ms-3">{{ __('Expenses') }}</h5>
                            </div>
                            <div class="border-start border-end">
                                @foreach ($chartAccounts as $accounts)
                                    @if ($accounts['Type'] == 'Expenses' || $accounts['Type'] == 'Costs of Goods Sold')
                                        <div class="account-main-inner border-bottom py-2">
                                            <p class="fw-bold mb-2 ms-3">{{ $accounts['Type'] }}</p>

                                            @foreach ($accounts['account'] as $key => $record)
                                            @php
                                            if($record['netAmount'] > 0)
                                            {
                                                $netAmount = $record['netAmount'];
                                            }
                                            else {
                                                $netAmount = -$record['netAmount'];
                                            }
                                        @endphp
                                                <div
                                                    class="account-inner d-flex align-items-center justify-content-between">
                                                    @if (!preg_match('/\btotal\b/i', $record['account_name']))
                                                        <p class="mb-2 ps-3 ms-3"><a
                                                                href="{{ route('report.ledger', $record['account_id']) }}?account={{ $record['account_id'] }}"
                                                                class="text-primary">{{ $record['account_name'] }}</a>
                                                        </p>
                                                    @else
                                                        <p class="fw-bold mb-2 ms-3"><a
                                                                href="{{ route('report.ledger', $record['account_id']) }}?account={{ $record['account_id'] }}"
                                                                class="text-dark">{{ $record['account_name'] }}</a>
                                                    @endif
                                                    <p class="mb-2 text-center">{{ $record['account_code'] }}</p>
                                                    @if (!preg_match('/\btotal\b/i', $record['account_name']))
                                                        <p class="text-primary mb-2 float-end text-end me-3">
                                                            {{ \Auth::user()->priceFormat($netAmount) }}</p>
                                                    @else
                                                        <p class="mb-2 float-end text-end me-3 fw-bold text-dark">
                                                            {{ \Auth::user()->priceFormat($netAmount) }}</p>
                                                    @endif
                                                </div>
                                                @php
                                                    if ($record['account_name'] === 'Total Income') {
                                                        $totalIncome = $record['netAmount'];
                                                    }
                                                    
                                                    if ($record['account_name'] == 'Total Costs of Goods Sold') {
                                                        $totalCosts = $netAmount;
                                                    }
                                                    $grossProfit = $totalIncome - $totalCosts;
                                                @endphp
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="aacount-title d-flex align-items-center justify-content-between border py-2">
                                <h5 class="mb-0 ms-3">{{ __('Income') }}</h5>
                            </div>
                            <div class="border-start border-end">
                                @foreach ($chartAccounts as $accounts)
                                    @if ($accounts['Type'] == 'Income')
                                        <div class="account-main-inner border-bottom py-2">
                                            <p class="fw-bold mb-2 ms-3">{{ $accounts['Type'] }}</p>

                                            @foreach ($accounts['account'] as $key => $record)
                                                <div
                                                    class="account-inner d-flex align-items-center justify-content-between">
                                                    @if (!preg_match('/\btotal\b/i', $record['account_name']))
                                                        <p class="mb-2 ps-3 ms-3"><a
                                                                href="{{ route('report.ledger', $record['account_id']) }}?account={{ $record['account_id'] }}"
                                                                class="text-primary">{{ $record['account_name'] }}</a>
                                                        </p>
                                                    @else
                                                        <p class="fw-bold mb-2 ms-3"><a
                                                                href="{{ route('report.ledger', $record['account_id']) }}?account={{ $record['account_id'] }}"
                                                                class="text-dark">{{ $record['account_name'] }}</a>
                                                    @endif
                                                    <p class="mb-2 text-center">{{ $record['account_code'] }}</p>

                                                    @if (!preg_match('/\btotal\b/i', $record['account_name']))
                                                        <p class="text-primary mb-2 float-end text-end me-3">
                                                            {{ \Auth::user()->priceFormat($record['netAmount']) }}</p>
                                                    @else
                                                        <p class="mb-2 float-end text-end me-3 fw-bold text-dark">
                                                            {{ \Auth::user()->priceFormat($record['netAmount']) }}</p>
                                                    @endif


                                                </div>

                                                @php
                                                    if ($record['account_name'] === 'Total Income') {
                                                        $totalIncome = $record['netAmount'];
                                                    }
                                                    
                                                    if ($record['account_name'] == 'Total Costs of Goods Sold') {
                                                        if($record['netAmount'] > 0)
                                                        {
                                                            $totalCosts = $record['netAmount'];
                                                        }
                                                        else {
                                                            $totalCosts = -$record['netAmount'];                                                            
                                                        }
                                                    }
                                                    $grossProfit = $totalIncome - $totalCosts;
                                                @endphp
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
