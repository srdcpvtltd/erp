@extends('layouts.admin')
@section('page-title')
    {{__('Farming Loans')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Loans')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create farmer loan')
        <a href="{{ route('farmer.loan.create') }}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        @endcan

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Farmer Name')}}</th>
                                <th>{{__('Registration No.')}}</th>
                                <th>{{__('Agreement No')}}</th>
                                <th>{{__('Date of Agreement')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Price')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($loans as $loan)
                                <tr class="font-style">
                                    <td>{{ @$loan->farming->name}}</td>
                                    <td>{{ $loan->registration_number}}</td>
                                    <td>{{ $loan->agreement_number}}</td>
                                    <td>{{ $loan->date}}</td>
                                    <td>{{ @$loan->category->name}}</td>
                                    <td>{{ @$loan->type->name}}</td>
                                    <td>{{ @$loan->price_kg}}</td>
                                    <td>{{ @$loan->quantity}}</td>
                                    <td>{{ @$loan->total_amount}}</td>
                      
                                    <td class="Action">
                                        @can('edit farmer loan')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="{{route('farmer.loan.edit',$loan->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('delete farmer loan')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['farmer.loan.destroy', $loan->id],'id'=>'delete-form-'.$loan->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
                                        </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
