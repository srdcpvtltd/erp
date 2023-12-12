
@extends('layouts.admin')
@section('page-title')
    {{__('Edit Farming Registration')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.farming_registration.index')}}">{{__('Farming Registration')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit Farming Registration')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
    <script>
        
    $(document).ready(function(){
        $('#country_id').change(function(){
            let country_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_states')}}",
                method: 'post',
                data: {
                    country_id: country_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    states = response.states;
                    $('#state_id').empty();
                    $('#state_id').append('<option value="">Select State</option>');
                    for (i=0;i<states.length;i++){
                        $('#state_id').append('<option value="'+states[i].id+'">'+states[i].name+'</option>');
                    }
                }
            });
        });
        $('#state_id').change(function(){
            let state_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_districts')}}",
                method: 'post',
                data: {
                    state_id: state_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    districts = response.districts;
                    $('#district_id').empty();
                    $('#district_id').append('<option  value="">Select District</option>');
                    for (i=0;i<districts.length;i++){
                        $('#district_id').append('<option value="'+districts[i].id+'">'+districts[i].name+'</option>');
                    }
                }
            });
        });
        $('#district_id').change(function(){
            let district_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_blocks')}}",
                method: 'post',
                data: {
                    district_id: district_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    blocks = response.blocks;
                    $('#block_id').empty();
                    $('#block_id').append('<option  value="">Select Blocks</option>');
                    for (i=0;i<blocks.length;i++){
                        $('#block_id').append('<option value="'+blocks[i].id+'">'+blocks[i].name+'</option>');
                    }
                }
            });
        });
        $('#block_id').change(function(){
            let block_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_gram_panchyats')}}",
                method: 'post',
                data: {
                    block_id: block_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    gram_panchyats = response.gram_panchyats;
                    $('#gram_panchyat_id').empty();
                    $('#gram_panchyat_id').append('<option  value="">Select Gram Panchyat</option>');
                    for (i=0;i<gram_panchyats.length;i++){
                        $('#gram_panchyat_id').append('<option value="'+gram_panchyats[i].id+'">'+gram_panchyats[i].name+'</option>');
                    }
                }
            });
        });
        $('#gram_panchyat_id').change(function(){
            let gram_panchyat_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_villages')}}",
                method: 'post',
                data: {
                    gram_panchyat_id: gram_panchyat_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    villages = response.villages;
                    $('#village_id').empty();
                    $('#village_id').append('<option  value="">Select Village</option>');
                    for (i=0;i<villages.length;i++){
                        $('#village_id').append('<option value="'+villages[i].id+'">'+villages[i].name+'</option>');
                    }
                }
            });
        });
    });

    </script>
@endpush

@section('content')
    <div class="row">
        {{ Form::model($farming, array('route' => array('farmer.farming_registration.update',$farming->id), 'method' => 'PUT','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
                            {{ Form::text('name', $farming->name, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('mobile', __('Mobile'),['class'=>'form-label']) }}
                            {{ Form::number('mobile', $farming->mobile, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
                            {{ Form::email('email', $farming->email, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('country_id', __('Country'),['class'=>'form-label']) }}
                                <select class="form-control select" name="country_id" id="country_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Country')}}</option>
                                    @foreach($countries as $country)
                                        <option {{$farming->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('state_id', __('State'),['class'=>'form-label']) }}
                                <select class="form-control select" name="state_id" id="state_id" placeholder="Select State" required>
                                    <option value="">{{__('Select State')}}</option>
                                    @foreach($states as $state)
                                        <option {{$farming->state_id == $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('district_id', __('District'),['class'=>'form-label']) }}
                                <select class="form-control select" name="district_id" id="district_id" placeholder="Select District" required>
                                    <option value="">{{__('Select District')}}</option>
                                    @foreach($districts as $district)
                                        <option {{$farming->district_id == $district->id ? 'selected' : '' }} value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('block_id', __('Block'),['class'=>'form-label']) }}
                                <select class="form-control select" name="block_id" id="block_id" placeholder="Select Block" required>
                                    <option value="">{{__('Select Block')}}</option>
                                    @foreach($blocks as $block)
                                        <option {{$farming->block_id == $block->id ? 'selected' : '' }} value="{{ $block->id }}">{{ $block->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('gram_panchyat_id', __('Gram Panchyat'),['class'=>'form-label']) }}
                                <select class="form-control select" name="gram_panchyat_id" id="gram_panchyat_id" placeholder="Select Gram Panchyat" required>
                                    <option value="">{{__('Select Gram Panchyat')}}</option>
                                    @foreach($gram_panchyats as $gram_panchyat)
                                        <option {{$farming->gram_panchyat_id == $gram_panchyat->id ? 'selected' : '' }} value="{{ $gram_panchyat->id }}">{{ $gram_panchyat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('village_id', __('Village'),['class'=>'form-label']) }}
                                <select class="form-control select" name="village_id" id="village_id" placeholder="Select Village" required>
                                    <option value="">{{__('Select Village')}}</option>
                                    @foreach($villages as $village)
                                        <option {{$farming->village_id == $village->id ? 'selected' : '' }} value="{{ $village->id }}">{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('age', __('Age'),['class'=>'form-label']) }}
                            {{ Form::number('age', $farming->age, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}
                            <select class="form-control select" name="gender" id="gender" placeholder="Select Gender" required>
                                <option value="">{{__('Select Gender')}}</option>
                                <option {{$farming->gender == 'Male' ? 'selected' : ''}} value="Male">{{__('Male')}}</option>
                                <option {{$farming->gender == 'Female' ? 'selected' : ''}} value="Female">{{__('Female')}}</option>
                            </select>                        
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('qualification', __('Qualification'),['class'=>'form-label']) }}
                            <select class="form-control select" name="qualification" id="qualification" placeholder="Select Qualification" required>
                                <option value="">{{__('Select Qualification')}}</option>
                                <option {{$farming->qualification == '10th Standard' ? 'selected' : ''}} value="10th Standard">{{__('10th Standard')}}</option>
                                <option {{$farming->qualification == '12th Standard' ? 'selected' : ''}} value="12th Standard">{{__('12th Standard')}}</option>
                                <option {{$farming->qualification == 'Bachelor Degree' ? 'selected' : ''}} value="Bachelor Degree">{{__('Bachelor Degree')}}</option>
                                <option {{$farming->qualification == 'Master Degree' ? 'selected' : ''}} value="Master Degree">{{__('Master Degree')}}</option>
                                <option {{$farming->qualification == 'PHD' ? 'selected' : ''}} value="PHD">{{__('PHD')}}</option>
                            </select>  
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('land_holding', __('Land Holding'),['class'=>'form-label']) }}
                            {{ Form::text('land_holding', $farming->land_holding, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('language', __('Language'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="language" value="Hindi" {{$farming->language == 'Hindi' ? 'checked' :'' }}> Hindi</label>
                            <label><input type="radio" name="language" value="English" {{$farming->language == 'English' ? 'checked' :'' }}> English</label>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('sms_mode', __('Sms Mode'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="sms_mode"  {{$farming->sms_mode == 'Text' ? 'checked' :'' }} value="Text" checked> Text</label>
                            <label><input type="radio" name="sms_mode"  {{$farming->sms_mode == 'Voice' ? 'checked' :'' }} value="Voice"> Voice</label>
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("farmer.farming_registration.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
        </div>
    {{ Form::close() }}
    </div>

@endsection

