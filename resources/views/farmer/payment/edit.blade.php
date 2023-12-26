
@extends('layouts.admin')
@section('page-title')
    {{__('Edit Farming Security Deposit')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.payment.index')}}">{{__('Farming Security Deposit')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit Farming Security Deposit')}}</li>
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
                                    <option {{$farming->id == $payment->farming_id ? 'selected' : '' }} value="{{ $farming->id }}">{{ $farming->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('registration_number', __('Registration No.'),['class'=>'form-label']) }}
                            {{ Form::text('registration_number',   $payment->registration_number , array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('agreement_number', __('Agreement No.'),['class'=>'form-label']) }}
                            {{ Form::text('agreement_number',  $payment->agreement_number , array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date', __('Date of Deposit'),['class'=>'form-label']) }}
                            {{ Form::date('date',  $payment->date, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}
                            {{ Form::number('amount', $payment->amount, array('class' => 'form-control','step'=>'0.01','required'=>'required')) }}
                        </div>                    
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("farmer.payment.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
        </div>
    {{ Form::close() }}
    </div>

@endsection

