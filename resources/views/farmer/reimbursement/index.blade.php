@extends('layouts.admin')
@section('page-title')
    {{__('Farming Reimbursement')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Reimbursement')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create farmer reimbursement')
        <a href="{{ route('farmer.reimbursement.create') }}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Type')}}</th>
                                <th>{{__('Farmer Name')}}</th>
                                <th>{{__('Registration No.')}}</th>
                                <th>{{__('Agreement No.')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $payment)
                                <tr class="font-style">
                                    <td>{{ @$payment->type}}</td>
                                    <td>{{ @$payment->farming->name}}</td>
                                    <td>{{ $payment->registration_number}}</td>
                                    <td>{{ $payment->agreement_number}}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ $payment->amount }}</td>
                      
                                    <td class="Action">
                                        @can('edit farmer reimbursement')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="{{route('farmer.payment.edit',$payment->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('delete farmer reimbursement')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['farmer.payment.destroy', $payment->id],'id'=>'delete-form-'.$payment->id]) !!}
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
