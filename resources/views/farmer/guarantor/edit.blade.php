
@extends('layouts.admin')
@section('page-title')
    {{__('Edit Farming Guarantor')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.guarantor.index')}}">{{__('Farming Guarantor')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit Farming Guarantor')}}</li>
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
        {{ Form::model($guarantor, array('route' => array('farmer.guarantor.update',$guarantor->id), 'method' => 'PUT','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
                            {{ Form::text('name', $guarantor->name, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('father_name', __('Father Name'),['class'=>'form-label']) }}
                            {{ Form::text('father_name', $guarantor->father_name, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('farming_id', __('Farmer Registration'),['class'=>'form-label']) }}
                                <select class="form-control select" name="farming_id" id="farming_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Farmer Registration')}}</option>
                                    @foreach($farmings as $farming)
                                        <option {{$farming->id == $guarantor->farming_id ? 'selected' : '' }} value="{{ $farming->id }}">{{ $farming->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('country_id', __('Country'),['class'=>'form-label']) }}
                                <select class="form-control select" name="country_id" id="country_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Country')}}</option>
                                    @foreach($countries as $country)
                                        <option {{$guarantor->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
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
                                        <option {{$guarantor->state_id == $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->name }}</option>
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
                                        <option {{$guarantor->district_id == $district->id ? 'selected' : '' }} value="{{ $district->id }}">{{ $district->name }}</option>
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
                                        <option {{$guarantor->block_id == $block->id ? 'selected' : '' }} value="{{ $block->id }}">{{ $block->name }}</option>
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
                                        <option {{$guarantor->gram_panchyat_id == $gram_panchyat->id ? 'selected' : '' }} value="{{ $gram_panchyat->id }}">{{ $gram_panchyat->name }}</option>
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
                                        <option {{$guarantor->village_id == $village->id ? 'selected' : '' }} value="{{ $village->id }}">{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('post_office', __('Post Office'),['class'=>'form-label']) }}
                            {{ Form::text('post_office', $guarantor->post_office, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('police_station', __('Police Station'),['class'=>'form-label']) }}
                            {{ Form::text('police_station', $guarantor->police_station, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('registration_number', __('Registration No.'),['class'=>'form-label']) }}
                            {{ Form::text('registration_number', $guarantor->registration_number, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('age', __('Age'),['class'=>'form-label']) }}
                            {{ Form::number('age', $guarantor->age, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("farmer.guarantor.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
        </div>
    {{ Form::close() }}
    </div>

@endsection

