
@extends('layouts.admin')
@section('page-title')
    {{__('Edit Farming Bank Guarantee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.bank_guarantee.index')}}">{{__('Farming Bank Guarantee')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit Farming Bank Guarantee')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
@endpush

@section('content')
    <div class="row">
        {{ Form::model($payment, array('route' => array('farmer.payment.update',$payment->id), 'method' => 'PUT','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('farming_id', __('Farmer Registration'),['class'=>'form-label']) }}
                                <select class="form-control select" name="farming_id" id="farming_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Farmer Registration')}}</option>
                                    @foreach($farmings as $farming)
                                    <option {{$farming->id == $payment->farming_id ? 'selected' : '' }} value="{{ $farming->id }}">{{ $farming->name .'-'.$farming->farmer_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('bank', __('Bank'),['class'=>'form-label']) }}
                                <select class="form-control select" name="bank" id="bank" required placeholder="Select Country">
                                    <option value="">{{__('Select Bank')}}</option>
                                    <option {{$payment->bank && $payment->bank == 'State Bank of India (SBI)' ? 'selected' : '' }} value="State Bank of India (SBI)">State Bank of India (SBI)</option>
                                    <option {{$payment->bank && $payment->bank == 'Punjab National Bank (PNB)' ? 'selected' : '' }}  value="Punjab National Bank (PNB)">Punjab National Bank (PNB)</option>
                                    <option {{$payment->bank && $payment->bank == 'Bank of Baroda (BOB)' ? 'selected' : '' }} value="Bank of Baroda (BOB)">Bank of Baroda (BOB)</option>
                                    <option {{$payment->bank && $payment->bank == 'Canara Bank' ? 'selected' : '' }} value="Canara Bank">Canara Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Union Bank of India' ? 'selected' : '' }} value="Union Bank of India">Union Bank of India</option>
                                    <option {{$payment->bank && $payment->bank == 'HDFC Bank' ? 'selected' : '' }} value="HDFC Bank">HDFC Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'ICICI Bank' ? 'selected' : '' }} value="ICICI Bank">ICICI Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Axis Bank' ? 'selected' : '' }} value="Axis Bank">Axis Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Kotak Mahindra Bank' ? 'selected' : '' }} value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'IndusInd Bank' ? 'selected' : '' }} value="IndusInd Bank">IndusInd Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Yes Bank' ? 'selected' : '' }} value="Yes Bank">Yes Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'IDBI Bank' ? 'selected' : '' }} value="IDBI Bank">IDBI Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Central Bank of India' ? 'selected' : '' }} value="Central Bank of India">Central Bank of India</option>
                                    <option {{$payment->bank && $payment->bank == 'Indian Bank' ? 'selected' : '' }} value="Indian Bank">Indian Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Bank of India' ? 'selected' : '' }} value="Bank of India">Bank of India</option>
                                    <option {{$payment->bank && $payment->bank == 'Oriental Bank of Commerce (OBC)' ? 'selected' : '' }} value="Oriental Bank of Commerce (OBC)">Oriental Bank of Commerce (OBC)</option>
                                    <option {{$payment->bank && $payment->bank == 'Corporation Bank' ? 'selected' : '' }} value="Corporation Bank">Corporation Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Andhra Bank' ? 'selected' : '' }} value="Andhra Bank">Andhra Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Allahabad Bank' ? 'selected' : '' }} value="Allahabad Bank">Allahabad Bank</option>
                                    <option {{$payment->bank && $payment->bank == 'Syndicate Bank' ? 'selected' : '' }} value="Syndicate Bank">Syndicate Bank</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date', __('Loan Disbursement Date'),['class'=>'form-label']) }}
                            {{ Form::date('date',   $payment->date, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('amount', __('Loan Amount'),['class'=>'form-label']) }}
                            {{ Form::number('amount',  $payment->amount, array('class' => 'form-control','step'=>'0.01')) }}
                        </div>   
                        <div class="form-group col-md-6">
                            {{ Form::label('loan_account_number', __('Loan Account No'),['class'=>'form-label']) }}
                            {{ Form::text('loan_account_number',$payment->loan_account_number, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('ifsc', __('IFSC'),['class'=>'form-label']) }}
                            {{ Form::text('ifsc',$payment->ifsc, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('branch', __('Branch'),['class'=>'form-label']) }}
                            {{ Form::text('branch',$payment->branch, array('class' => 'form-control')) }}
                        </div>          
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("farmer.bank_guarantee.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
        </div>
    {{ Form::close() }}
    </div>

@endsection

