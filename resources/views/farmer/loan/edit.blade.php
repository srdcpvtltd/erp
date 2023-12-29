
@extends('layouts.admin')
@section('page-title')
    {{__('Edit Farming Loan')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('farmer.loan.index')}}">{{__('Farming Loan')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit Farming Loan')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
    <script>  
    $(document).ready(function(){
        $('#farming_id').change(function(){
            let farming_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.loan.get_farming_detail')}}",
                method: 'post',
                data: {
                    farming_id: farming_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#registration_number').val(response.farming.registration_no);
                    // $('#agreement_number').val(response.farming.registration_number);
                }
            });
        });
        $('#loan_category_id').change(function(){
            let loan_category_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.loan.get_product_service_by_category')}}",
                method: 'post',
                data: {
                    loan_category_id: loan_category_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    product_services = response.product_services;
                    $('#loan_type_id').empty();
                    $('#loan_type_id').append('<option value="">Select Product Service</option>');
                    for (i=0;i<product_services.length;i++){
                        $('#loan_type_id').append('<option value="'+product_services[i].id+'">'+product_services[i].name+'</option>');
                    }
                }
            });
        });
        $('#loan_type_id').change(function(){
            let loan_type_id = $(this).val();
            $.ajax({
                url: "{{route('farmer.loan.get_product_service_detail')}}",
                method: 'post',
                data: {
                    loan_type_id: loan_type_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#price_kg').val(response.product_service.sale_price);
                    $('#quantity').attr('max',response.quantity);
                    $('#max_text').html('Total Allowed Stock : '+response.quantity);
                }
            });
        });
        $('#quantity').change(function(){
            let quantity = $(this).val();
            let price = $('#price_kg').val();
            $('#total_amount').val(quantity * price);
        });
    });
    </script>
@endpush

@section('content')
    <div class="row">
        {{ Form::model($loan, array('route' => array('farmer.loan.update',$loan->id), 'method' => 'PUT','class'=>'w-100')) }}
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
                                        <option {{$farming->id == $loan->farming_id ? 'selected' : '' }} value="{{ $farming->id }}">{{ $farming->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('registration_number', __('Registration No.'),['class'=>'form-label']) }}
                            {{ Form::text('registration_number', $loan->registration_number, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('agreement_number', __('Agreement No.'),['class'=>'form-label']) }}
                            {{ Form::text('agreement_number',  $loan->agreement_number, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('date', __('Date of Deposit'),['class'=>'form-label']) }}
                            {{ Form::date('date',  $loan->date, array('class' => 'form-control','required'=>'required')) }}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('loan_category_id', __('Loan Category'),['class'=>'form-label']) }}
                                <select class="form-control select" name="loan_category_id" id="loan_category_id" required placeholder="Select Country">
                                    <option value="">{{__('Select Loan Category')}}</option>
                                    @foreach($categories as $category)
                                        <option {{$category->id == $loan->loan_category_id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('loan_type_id', __('Loan Type'),['class'=>'form-label']) }}
                                <select class="form-control select" name="loan_type_id" id="loan_type_id" placeholder="Select Type" required>
                                    <option value="">{{__('Select Loan Type')}}</option>
                                    @foreach($types as $type)
                                        <option {{$type->id == $loan->loan_category_id ? 'selected' : ''}} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('price_kg', __('Price Kg'),['class'=>'form-label']) }}
                            {{ Form::text('price_kg',  $loan->price_kg, array('class' => 'form-control','id' => 'price_kg','required'=>'required','readonly' => true,'placeholder'=>'Price Kg')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}
                            {{ Form::number('quantity',  $loan->quantity, array('class' => 'form-control','min'=>'1','required'=>'required','id'=>'quantity')) }}
                            <span style="color:red;" id="max_text"></span>
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('total_amount', __('Total Amount'),['class'=>'form-label']) }}
                            {{ Form::number('total_amount',  $loan->total_amount, array('class' => 'form-control','required'=>'required','readonly' => true,'placeholder'=>'Total Amount','id' => 'total_amount')) }}
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

