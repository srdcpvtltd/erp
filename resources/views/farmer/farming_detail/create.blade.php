
@extends('layouts.admin')
@section('page-title')
    {{__('Farming Detail Create')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.farming_detail.index')}}">{{__('Farming Registration')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Detail Create')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
@endpush

@section('content')
    <div class="row">
        {{ Form::open(array('url' => 'farmer/farming_detail','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="created_by" id="created_by" value="{{ Auth::user()->id }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('farming_id', __('Farming'),['class'=>'form-label']) }}
                                <select class="form-control select" name="farming_id" id="farming_id" required placeholder="Select Farmer">
                                    <option value="">{{__('Select Farmer')}}</option>
                                    @foreach($farmings as $farming)
                                        <option value="{{ $farming->id }}">{{ $farming->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
                            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('plot_number', __('Plot Number'),['class'=>'form-label']) }}
                            {{ Form::text('plot_number', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('kata_number', __('Kata Number'),['class'=>'form-label']) }}
                            {{ Form::text('kata_number', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('area_in_acar', __('Area in acar'),['class'=>'form-label']) }}
                            {{ Form::text('area_in_acar', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date_of_harvesting', __('Date of Harvesting'),['class'=>'form-label']) }}
                            {{ Form::date('date_of_harvesting', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}
                            {{ Form::number('quantity', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('tentative_harvest_quantity', __('Tentative Harvest Quantity'),['class'=>'form-label']) }}
                            {{ Form::number('tentative_harvest_quantity', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('seed_category_id', __('Seed Category'),['class'=>'form-label']) }}
                                <select class="form-control select" name="seed_category_id" id="seed_category_id" required placeholder="Select Seed Category">
                                    <option value="">{{__('Select Seed Category')}}</option>
                                    @foreach($seed_categories as $seed_category)
                                        <option value="{{ $seed_category->id }}">{{ $seed_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("farmer.farming_detail.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
        </div>
    {{ Form::close() }}
    </div>

@endsection

