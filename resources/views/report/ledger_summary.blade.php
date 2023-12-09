@extends('layouts.admin')
@section('page-title')
    {{ __('Ledger Summary') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Ledger Summary') }}</li>
@endsection
@push('script-page')
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
@endpush

@section('action-btn')
    <div class="float-end">
        {{--        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{__('Filter')}}"> --}}
        {{--            <i class="ti ti-filter"></i> --}}
        {{--        </a> --}}

        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"data-bs-toggle="tooltip"
            title="{{ __('Download') }}" data-original-title="{{ __('Download') }}">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['report.ledger'], 'method' => 'GET', 'id' => 'report_ledger']) }}

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('start_date', $filter['startDateRange'], ['class' => 'month-btn form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('end_date', $filter['endDateRange'], ['class' => 'month-btn form-control']) }}
                                        </div>
                                    </div>



                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                                            {{ Form::select('account', $accounts, isset($_GET['account']) ? $_GET['account'] : '', ['class' => 'form-control select']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('report_ledger').submit(); return false;"
                                            data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                            data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{ route('report.ledger') }}" class="btn btn-sm btn-danger "
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



    <div id="printableArea">
        {{-- <div class="row mt-2">
            <div class="col">
                <input type="hidden"
                    value="{{ __('Ledger') . ' ' . 'Report of' . ' ' . $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{ __('Report') }} :</h6>
                    <h7 class="text-sm mb-0">{{ __('Ledger Summary') }}</h7>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{ __('Duration') }} :</h6>
                    <h7 class="text-sm mb-0">{{ $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}</h7>
                </div>
            </div>
        </div> --}}
        {{-- @if (!empty($account))
            <div class="row mt-2">
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{ __('Account Name') }} :</h6>
                        <h7 class="text-sm mb-0">{{ $account->name }}</h7>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{ __('Account Code') }} :</h6>
                        <h7 class="text-sm mb-0">{{ $account->code }}</h7>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{ __('Total Debit') }} :</h6>
                        <h7 class="text-sm mb-0">{{ \Auth::user()->priceFormat($filter['debit']) }}</h7>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{ __('Total Credit') }} :</h6>
                        <h7 class="text-sm mb-0">{{ \Auth::user()->priceFormat($filter['credit']) }}</h7>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{ __('Balance') }} :</h6>
                        <h7 class="text-sm mb-0">
                            {{ $filter['balance'] > 0 ? __('Cr') . '. ' . \Auth::user()->priceFormat(abs($filter['balance'])) : __('Dr') . '. ' . \Auth::user()->priceFormat(abs($filter['balance'])) }}
                        </h7>
                    </div>
                </div>
            </div>
        @endif --}}
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> {{ __('Account Name') }}</th>
                                        <th> {{ __('Name') }}</th>
                                        <th> {{ __('Transaction Type') }}</th>
                                        <th> {{ __('Transaction Date') }}</th>
                                        <th> {{ __('Debit') }}</th>
                                        <th> {{ __('Credit') }}</th>
                                        <th> {{ __('Balance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $balance = 0;
                                        $totalDebit = 0;
                                        $totalCredit = 0;

                                        $accountArrays = [];
                                        foreach ($accountss as $key => $account) {
                                            $chartDatas = App\Models\Utility::getAccountData($account->id, $filter['startDateRange'], $filter['endDateRange']);

                                            $a = [0 => ['account' => $account->id]];
                                            $chartDatas = array_merge($chartDatas, $a);

                                            $accountArrays[] = $chartDatas;
                                        }
                                    @endphp
                                    @foreach ($accountArrays as $account)
                                        @foreach ($account[0] as $a)
                                            @php $accountName = \App\Models\ChartOfAccount::find($a); @endphp

                                            @foreach ($account['invoice'] as $invoiceData)
                                                @if ($account['invoice'] != [])
                                                    <tr>
                                                        <td>{{ $accountName->name }}</td>
                                                        @php
                                                            $invoice = \App\Models\Invoice::where('id', $invoiceData->invoice_id)->first();
                                                        @endphp
                                                        <td>{{ !empty($invoice->customer) ? $invoice->customer->name : '-' }}
                                                        </td>
                                                        <td>{{ \Auth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                        </td>
                                                        <td>{{ $invoiceData->created_at->format('d-m-Y') }}</td>
                                                        <td>-</td>

                                                        @php
                                                            $total = $invoiceData->price * $invoiceData->quantity;
                                                            $balance += $total;
                                                            $totalCredit += $total;
                                                        @endphp
                                                        <td>{{ \Auth::user()->priceFormat($total) }}</td>
                                                        <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @foreach ($account['invoicepayment'] as $invoicePaymentData)
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    @php
                                                        $invoice = \App\Models\Invoice::where('id', $invoicePaymentData->invoice_id)->first();
                                                    @endphp
                                                    <td>{{ !empty($invoice->customer) ? $invoice->customer->name : '-' }}
                                                    </td>
                                                    <td>{{ \Auth::user()->invoiceNumberFormat($invoice->invoice_id) }}
                                                        {{ __(' Manually Payment') }}</td>
                                                    <td>{{ $invoicePaymentData->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($invoicePaymentData->amount) }}</td>
                                                    <td>-</td>
                                                    @php
                                                        $balance += $invoicePaymentData->amount;
                                                        $totalCredit += $invoicePaymentData->amount;
                                                    @endphp
                                                    <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                </tr>
                                            @endforeach

                                            @foreach ($account['revenue'] as $revenueData)
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    <td>{{ !empty($revenueData->customer) ? $revenueData->customer->name : '-' }}
                                                    </td>
                                                    <td>{{ __('Revenue') }}</td>
                                                    <td>{{ $revenueData->created_at->format('d-m-Y') }}</td>
                                                    <td>-</td>
                                                    <td>{{ \Auth::user()->priceFormat($revenueData->amount) }}</td>
                                                    @php
                                                        $balance += $revenueData->amount;
                                                        $totalCredit += $revenueData->amount;
                                                    @endphp
                                                    <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                </tr>
                                            @endforeach

                                            @foreach ($account['bill'] as $billProduct)
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    @php

                                                        $bill = \App\Models\Bill::find($billProduct->bill_id);
                                                        $vendor = \App\Models\Vender::find(!empty($bill) ? $bill->vender_id : '');
                                                    @endphp
                                                    <td>{{ !empty($vendor) ? $vendor->name : '-' }}</td>
                                                    <td>{{ \Auth::user()->billNumberFormat($bill->bill_id) }}</td>
                                                    <td>{{ $billProduct->created_at->format('d-m-Y') }}</td>

                                                    @php
                                                        $total = $billProduct->price * $billProduct->quantity;
                                                        $balance -= $total;
                                                        $totalCredit -= $total;
                                                    @endphp
                                                    <td>{{ \Auth::user()->priceFormat($total) }}</td>
                                                    <td>-</td>
                                                    <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                </tr>
                                            @endforeach

                                            @foreach ($account['billdata'] as $billData)
                                                @php
                                                    $bill = \App\Models\Bill::find($billData->ref_id);
                                                    $vendor = \App\Models\Vender::find(!empty($bill) ? $bill->vender_id : '');
                                                @endphp
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    <td>{{ !empty($vendor) ? $vendor->name : '-' }}</td>
                                                    @if (!empty($bill->bill_id))
                                                        <td>{{ \Auth::user()->billNumberFormat($bill->bill_id) }}</td>
                                                    @else
                                                        <td>-</td>
                                                    @endif

                                                    <td>{{ $billData->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ \Auth::user()->priceFormat($billData->price) }}</td>
                                                    <td>-</td>
                                                    @php
                                                        $balance -= $billData->price;
                                                        $totalDebit -= $billData->price;
                                                    @endphp
                                                    <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                </tr>
                                            @endforeach

                                            @foreach ($account['billpayment'] as $billPaymentData)
                                                @if ($account['billpayment'] != [])
                                                    @php
                                                        $bill = \App\Models\BillPayment::where('bill_id', $billPaymentData->bill_id)->first();
                                                        $billId = \App\Models\Bill::find($billPaymentData->bill_id);
                                                        $vendor = \App\Models\Vender::find($billId->vender_id);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $accountName->name }}</td>
                                                        <td>{{ !empty($vendor) ? $vendor->name : '-' }}</td>
                                                        <td>{{ \Auth::user()->billNumberFormat($billId->bill_id) }}{{ __(' Manually Payment') }}
                                                        </td>
                                                        <td>{{ $billPaymentData->created_at->format('d-m-Y') }}</td>
                                                        <td>{{ \Auth::user()->priceFormat($billPaymentData->amount) }}</td>
                                                        <td>-</td>
                                                        @php
                                                            $balance -= $billPaymentData->amount;
                                                            $totalDebit += $billPaymentData->amount;
                                                        @endphp
                                                        <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @foreach ($account['payment'] as $paymentData)
                                                @php
                                                    $vendor = \App\Models\Vender::find($paymentData->vender_id);
                                                @endphp
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    <td>{{ !empty($vendor) ? $vendor->name : '-' }}</td>
                                                    <td>{{ __('Payment') }}</td>
                                                    <td>{{ $paymentData->created_at->format('d-m-Y') }}</td>

                                                    <td>{{ \Auth::user()->priceFormat($paymentData->amount) }}</td>
                                                    <td>-</td>
                                                    @php
                                                        $balance -= $paymentData->amount;
                                                        $totalDebit += $paymentData->amount;
                                                    @endphp
                                                    <td>{{ \Auth::user()->priceFormat($balance) }}</td>
                                                </tr>
                                            @endforeach

                                            @php
                                                $debit = 0;
                                                $credit = 0;
                                            @endphp
                                            @foreach ($account['journalItem'] as $journalItemData)
                                                <tr>
                                                    <td>{{ $accountName->name }}</td>
                                                    <td>{{ '-' }}</td>
                                                    <td>{{ AUth::user()->journalNumberFormat($journalItemData->journal_id) }}
                                                    </td>
                                                    <td>{{ $journalItemData->created_at->format('d-m-Y') }}</td>
                                                    @if ($journalItemData->debit == 0)
                                                        <td>{{ '-' }}</td>
                                                    @else
                                                        <td>{{ Auth::user()->priceFormat($journalItemData->debit) }}</td>
                                                    @endif
                                                    @if ($journalItemData->credit == 0)
                                                        <td> {{ '-' }}</td>
                                                    @else
                                                        <td>{{ \Auth::user()->priceFormat($journalItemData->credit) }}</td>
                                                    @endif
                                                    <td>
                                                        @if ($journalItemData->debit)
                                                            @php $balance-= $journalItemData->debit @endphp
                                                        @else
                                                            @php $balance+= $journalItemData->credit @endphp
                                                        @endif
                                                        {{ \Auth::user()->priceFormat($balance) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
