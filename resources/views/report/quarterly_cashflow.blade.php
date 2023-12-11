@extends('layouts.admin')
@section('page-title')
    {{__('Cash Flow')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Cash Flow')}}</li>
@endsection
@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var year = '{{$currentYear}}';
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endpush

@section('action-btn')
    <div class="float-end">
        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"data-bs-toggle="tooltip" title="{{__('Download')}}" data-original-title="{{__('Download')}}">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>
    </div>
@endsection


@section('content')

    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
               href="{{ route('report.monthly.cashflow') }}"
               onclick="window.location.href = '{{ route('report.monthly.cashflow') }}'" role="tab"
               aria-controls="pills-home" aria-selected="true">{{ __('Monthly') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#" role="tab"
               aria-controls="pills-profile" aria-selected="false">{{ __('Quarterly') }}</a>
        </li>
    </ul>


    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('report.quarterly.cashflow'),'method' => 'GET','id'=>'quarterly_cashflow')) }}
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

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('year', __('Year'),['class'=>'form-label'])}}

                                            {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">
                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('quarterly_cashflow').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{route('report.quarterly.cashflow')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
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

    <div id="printableArea">
        <div class="row mt-1">
            <div class="col">
                <input type="hidden" value="{{__('Quarterly Cashflow').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Report')}} :</h7>
                    <h6 class="report-text mb-0">{{__('Quarterly Cashflow')}}</h6>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Duration')}} :</h7>
                    <h6 class="report-text mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="pb-3">{{__('Income')}}</h5>
                                <div class="table-responsive mt-3 mb-3">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th width="25%">{{__('Category')}}</th>
                                            @foreach($month as $m)
                                                <th width="15%">{{$m}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="13" class="font-bold"><span>{{__('Revenue : ')}}</span></td>
                                        </tr>
                                        @if(!empty($revenueIncomeArray))
                                            @foreach($revenueIncomeArray as $i=>$revenue)
                                                <tr>
                                                    <td>{{$revenue['category']}}</td>
                                                    @foreach($revenue['amount'] as $j=>$amount)
                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif

                                        <tr>
                                            <td colspan="13" class="font-bold"><span>{{__('Invoice : ')}}</span></td>
                                        </tr>
                                        {{--                                            @dd($invoiceIncomeArray)--}}
                                        @if(!empty($invoiceIncomeArray))
                                            @foreach($invoiceIncomeArray as $i=>$invoice)
                                                <tr>
                                                    <td>{{$invoice['category']}}</td>
                                                    @foreach($invoice['amount'] as $j=>$amount)
                                                        <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush border">
                                                    <tbody>
                                                    <tr>
                                                        <td colspan="13" class="font-bold"><span>{{__('Total Income =  Revenue + Invoice ')}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%" class="text-dark">{{__('Total Income')}}</td>
                                                        @foreach($totalIncome as $income)
                                                            <td width="15%">{{\Auth::user()->priceFormat($income)}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-12">
                                    <h5>{{__('Expense')}}</h5>
                                    <div class="table-responsive mt-4">
                                        <table class="table mb-0" >
                                            <thead>
                                            <tr>
                                                <th width="25%">{{__('Category')}}</th>
                                                @foreach($month as $m)
                                                    <th width="15%">{{$m}}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="13" class="font-bold"><span>{{__('Payment : ')}}</span></td>
                                            </tr>
                                            @if(!empty($expenseArray))
                                                @foreach($expenseArray as $i=>$expense)
                                                    <tr>
                                                        <td>{{$expense['category']}}</td>
                                                        @foreach($expense['amount'] as $j=>$amount)
                                                            <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="13" class="font-bold"><span>{{__('Bill : ')}}</span></td>
                                            </tr>
                                            @if(!empty($billExpenseArray))
                                                @foreach($billExpenseArray as $i=>$bill)
                                                    <tr>
                                                        <td>{{$bill['category']}}</td>
                                                        @foreach($bill['amount'] as $j=>$amount)
                                                            <td width="15%">{{\Auth::user()->priceFormat($amount)}}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-flush border" >
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="13" class="font-bold"><span>{{__('Total Expense =  Payment + Bill ')}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-dark">{{__('Total Expenses')}}</td>
                                                            @foreach($totalExpense as $expense)
                                                                <td width="15%">{{\Auth::user()->priceFormat($expense)}}</td>
                                                            @endforeach
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-flush border" >
                                                <tbody>
                                                    <thead>
                                                    <tr>
                                                        <th colspan="13" class="font-bold"><span>{{__('Net Profit = Total Income - Total Expense ')}}</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tr>
                                                        <td width="25%" class="text-dark">{{__('Net Profit')}}</td>
                                                        @foreach($netProfitArray as $i=>$profit)
                                                            <td width="15%"> {{\Auth::user()->priceFormat($profit)}}</td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


