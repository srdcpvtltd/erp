@extends('layouts.admin')
@section('page-title')
    {{__('Farming Registration Detail')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Registration Detail')}}</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">    
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="farmer-detail-tab" data-bs-toggle="pill" href="#detail" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Farmer Registration Detail')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="farmer-guarantor-tab" data-bs-toggle="pill" href="#guarantor" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Farmer Guarantors')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="farmer-payment-tab" data-bs-toggle="pill" href="#payment" role="tab" aria-controls="pills-contact" aria-selected="false">{{__('Farmer Payments')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="pills-home-tab">
                            @include('farmer.registration.partials.detail')
                        </div>
                        <div class="tab-pane fade" id="guarantor" role="tabpanel" aria-labelledby="pills-profile-tab">
                            @include('farmer.registration.partials.guarantors')
                        </div>
                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @include('farmer.registration.partials.payments')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
