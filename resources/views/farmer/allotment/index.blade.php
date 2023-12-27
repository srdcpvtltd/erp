@extends('layouts.admin')
@section('page-title')
    {{__('Farming Allotment')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Allotment')}}</li>
@endsection
@section('action-btn')

@endsection

@section('content')
<div class="row">

    <div class="col-lg-4 col-md-6">
        <a href="{{route('farmer.bank_guarantee.index')}}">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    {{-- <small class="text-muted">{{__('Issue')}}</small> --}}
                                    <h6 class="m-0">{{__('Issue Bank Guarantee')}}</h6>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-auto text-end">
                            <h4 class="m-0">{{ $home_data['total_project']['total'] }}</h4>
                        </div> --}}
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-activity"></i>
                            </div>
                            <div class="ms-3">
                                {{-- <small class="text-muted">{{__('Total')}}</small> --}}
                                <h6 class="m-0">{{__('Seeds Allotment')}}</h6>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-auto text-end">
                        <h4 class="m-0">{{ $home_data['total_task']['total'] }}</h4>
                        <small class="text-muted"><span class="text-success">{{ $home_data['total_task']['percentage'] }}%</span> {{__('completd')}}</small>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-report-money"></i>
                            </div>
                            <div class="ms-3">
                                {{-- <small class="text-muted">{{__('Total')}}</small> --}}
                                <h6 class="m-0">{{__('Fertiliser Allotment')}}</h6>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-auto text-end">
                        <h4 class="m-0">{{ $home_data['total_expense']['total'] }}</h4>
                        <small class="text-muted"><span class="text-success">{{ $home_data['total_expense']['percentage'] }}%</span> {{__('expense')}}</small>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
