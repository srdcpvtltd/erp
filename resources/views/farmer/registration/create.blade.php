
@extends('layouts.admin')
@section('page-title')
    {{__('Farming Registration Create')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.farming_registration.index')}}">{{__('Farming Registration')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Registration Create')}}</li>
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
        $('#zone_id').change(function(){
            let zone_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.location.get_centers')}}",
                method: 'post',
                data: {
                    zone_id: zone_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    centers = response.centers;
                    $('#center_id').empty();
                    $('#center_id').append('<option  value="">Select Center</option>');
                    for (i=0;i<centers.length;i++){
                        $('#center_id').append('<option value="'+centers[i].id+'">'+centers[i].name+'</option>');
                    }
                }
            });
        });
        $('#non_loan_type').on('change', function(event) {
            var value = $(this).val();
            if (value == "Bank") {
                $('.coperative_fields').hide();
                $('.bank_detail_fields').show();
            } else {
                $('.bank_detail_fields').hide();
                $('.coperative_fields').show();
            }
        });
        $('input[type=radio][name="finance_category"]').on('change', function(event) {
            var value = $(this).val();
            if (value == "Loan") {
                $('.finance_category_fields').hide();
            } else {
                $('.finance_category_fields').show();
            }
        });
        $('input[type=radio][name="is_irregation"]').on('change', function(event) {
            var value = $(this).val();
            if (value == "1" || value == true) {
                $('.irregation_fields').show();
            } else {
                $('.irregation_fields').hide();
            }
        });
    });

    </script>
@endpush

@section('content')
    <div class="row">
        {{ Form::open(array('url' => 'farmer/farming_registration','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="created_by" id="created_by" value="{{ Auth::user()->id }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
                            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('father_name', __('Father / Husband Name'),['class'=>'form-label']) }}
                            {{ Form::text('father_name', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('mobile', __('Mobile'),['class'=>'form-label']) }}
                            {{ Form::number('mobile', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        {{-- <div class="form-group col-md-6">
                            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
                            {{ Form::email('email', '', array('class' => 'form-control','required'=>'required')) }}
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('country_id', __('Country'),['class'=>'form-label']) }}
                                <select class="form-control select" name="country_id" id="country_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Country')}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('state_id', __('State'),['class'=>'form-label']) }}
                                <select class="form-control select" name="state_id" id="state_id" placeholder="Select State" required>
                                    <option value="">{{__('Select State')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('district_id', __('District'),['class'=>'form-label']) }}
                                <select class="form-control select" name="district_id" id="district_id" placeholder="Select District" required>
                                    <option value="">{{__('Select District')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('block_id', __('Block'),['class'=>'form-label']) }}
                                <select class="form-control select" name="block_id" id="block_id" placeholder="Select Block" required>
                                    <option value="">{{__('Select Block')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('gram_panchyat_id', __('Gram Panchyat'),['class'=>'form-label']) }}
                                <select class="form-control select" name="gram_panchyat_id" id="gram_panchyat_id" placeholder="Select Gram Panchyat" required>
                                    <option value="">{{__('Select Gram Panchyat')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('village_id', __('Village'),['class'=>'form-label']) }}
                                <select class="form-control select" name="village_id" id="village_id" placeholder="Select Village" required>
                                    <option value="">{{__('Select Village')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('post_office', __('Post Office'),['class'=>'form-label']) }}
                            {{ Form::text('post_office', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('police_station', __('Police Station'),['class'=>'form-label']) }}
                            {{ Form::text('police_station',  '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('zone_id', __('Zone'),['class'=>'form-label']) }}
                                <select class="form-control select" name="zone_id" id="zone_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Zone')}}</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('center_id', __('Center'),['class'=>'form-label']) }}
                                <select class="form-control select" name="center_id" id="center_id" placeholder="Select Center" required>
                                    <option value="">{{__('Select Center')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('registration_no', __('Registration No.'),['class'=>'form-label']) }}
                            {{ Form::text('registration_no',  '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('age', __('Age'),['class'=>'form-label']) }}
                            {{ Form::number('age', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}
                            <select class="form-control select" name="gender" id="gender" placeholder="Select Gender" required>
                                <option value="">{{__('Select Gender')}}</option>
                                <option value="Male">{{__('Male')}}</option>
                                <option value="Female">{{__('Female')}}</option>
                            </select>                        
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('qualification', __('Qualification'),['class'=>'form-label']) }}
                            <select class="form-control select" name="qualification" id="qualification" placeholder="Select Qualification" required>
                                <option value="">{{__('Select Qualification')}}</option>
                                <option value="10th Standard">{{__('10th Standard')}}</option>
                                <option value="12th Standard">{{__('12th Standard')}}</option>
                                <option value="Bachelor Degree">{{__('Bachelor Degree')}}</option>
                                <option value="Master Degree">{{__('Master Degree')}}</option>
                                <option value="PHD">{{__('PHD')}}</option>
                            </select>  
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('land_holding', __('Land Holding (In Acre)'),['class'=>'form-label']) }}
                            {{ Form::number('land_holding', '', array('class' => 'form-control','step' => '0.01','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('offered_area', __('Offered Area'),['class'=>'form-label']) }}
                            {{ Form::text('offered_area', '', array('class' => 'form-control','required'=>'required')) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('finance_category', __('Finance Category'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="finance_category" value="Loan" checked> Loan</label>
                            <label><input type="radio" name="finance_category" value="Non-loan"> Non-loan</label>
                        </div>
                        <div class="col-md-6 finance_category_fields" style="display:none;">
                            <div class="form-group">
                                {{ Form::label('non_loan_type', __('Non Loan Type'),['class'=>'form-label']) }}
                                <select class="form-control select" name="non_loan_type" id="non_loan_type" placeholder="Select Loan Type">
                                    <option value="">{{__('Select')}}</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Co-Operative">Co-Operative</option>                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 bank_detail_fields" style="display:none;">
                            {{ Form::label('account_number', __('Account Number'),['class'=>'form-label']) }}
                            {{ Form::text('account_number', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="col-md-6 bank_detail_fields" style="display:none;">
                            <div class="form-group">
                                {{ Form::label('bank', __('Bank'),['class'=>'form-label']) }}
                                <select class="form-control select" name="bank" id="bank" placeholder="Select Country">
                                    <option value="">{{__('Select Bank')}}</option><option value="State Bank of India (SBI)">State Bank of India (SBI)</option>
                                    <option value="Punjab National Bank (PNB)">Punjab National Bank (PNB)</option>
                                    <option value="Bank of Baroda (BOB)">Bank of Baroda (BOB)</option>
                                    <option value="Canara Bank">Canara Bank</option>
                                    <option value="Union Bank of India">Union Bank of India</option>
                                    <option value="HDFC Bank">HDFC Bank</option>
                                    <option value="ICICI Bank">ICICI Bank</option>
                                    <option value="Axis Bank">Axis Bank</option>
                                    <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                    <option value="IndusInd Bank">IndusInd Bank</option>
                                    <option value="Yes Bank">Yes Bank</option>
                                    <option value="IDBI Bank">IDBI Bank</option>
                                    <option value="Central Bank of India">Central Bank of India</option>
                                    <option value="Indian Bank">Indian Bank</option>
                                    <option value="Bank of India">Bank of India</option>
                                    <option value="Oriental Bank of Commerce (OBC)">Oriental Bank of Commerce (OBC)</option>
                                    <option value="Corporation Bank">Corporation Bank</option>
                                    <option value="Andhra Bank">Andhra Bank</option>
                                    <option value="Allahabad Bank">Allahabad Bank</option>
                                    <option value="Syndicate Bank">Syndicate Bank</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 bank_detail_fields" style="display:none;">
                            {{ Form::label('branch', __('Branch'),['class'=>'form-label']) }}
                            {{ Form::text('branch', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6 bank_detail_fields" style="display:none;">
                            {{ Form::label('ifsc_code', __('IFSC Code'),['class'=>'form-label']) }}
                            {{ Form::text('ifsc_code', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6 coperative_fields" style="display:none;">
                            {{ Form::label('name_of_cooperative', __('Co-Operative Name'),['class'=>'form-label']) }}
                            {{ Form::text('name_of_cooperative', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-6 coperative_fields" style="display:none;">
                            {{ Form::label('cooperative_address', __('Co-Operative Address'),['class'=>'form-label']) }}
                            {{ Form::text('cooperative_address', '', array('class' => 'form-control')) }}
                        </div>
                          <div class="form-group col-md-3">
                            {{ Form::label('language', __('Language'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="language" value="Hindi" checked> Hindi</label>
                            <label><input type="radio" name="language" value="English"> English</label>
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('sms_mode', __('Sms Mode'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="sms_mode" value="Text" checked> Text</label>
                            <label><input type="radio" name="sms_mode" value="Voice"> Voice</label>
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('land_type', __('Land Type'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="land_type" value="Leased Land" checked> Leased Land</label>
                            <label><input type="radio" name="land_type" value="Owned Land"> Owned Land</label>
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('is_irregation', __('Is irregation Available'),['class'=>'form-label']) }}
                            <br>
                            <label><input type="radio" name="is_irregation" value="1" > Yes</label>
                            <label><input type="radio" name="is_irregation" value="0" checked> No</label>
                        </div>
                        <div class="form-group col-md-4 irregation_fields" style="display:none;">
                            {{ Form::label('irregation', __('Irregation'),['class'=>'form-label']) }}
                            <select class="form-control select" name="irregation" id="irregation" placeholder="Select Seed Category">
                                <option value="">{{__('Mode of Irregation')}}</option>
                                <option value="Wells">Wells</option>
                                <option value="Tube Wells">Tube Wells</option>
                                <option value="Lakes">Lakes</option>
                                <option value="Ponds">Ponds</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Dams and Canals">Dams and Canals</option>
                            </select>
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

