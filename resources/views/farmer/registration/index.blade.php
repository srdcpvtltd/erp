@extends('layouts.admin')
@section('page-title')
    {{__('Farming Registration')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Registration')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create farmering profile')
        <a href="{{ route('farmer.farming_registration.create') }}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Mobile')}}</th>
                                <th>{{__('Age')}}</th>
                                <th>{{__('Gender')}}</th>
                                <th>{{__('Qualification')}}</th>
                                <th>{{__('State')}}</th>
                                <th>{{__('District')}}</th>
                                <th>{{__('Block')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($farmings as $farming)
                                <tr class="font-style">
                                    <td>{{ $farming->name}}</td>
                                    <td>{{ $farming->email}}</td>
                                    <td>{{ $farming->mobile}}</td>
                                    <td>{{ $farming->age}}</td>
                                    <td>{{ $farming->gender}}</td>
                                    <td>{{ $farming->qualification}}</td>
                                    <td>{{ @$farming->state->name }}</td>
                                    <td>{{ @$farming->district->name }}</td>
                                    <td>{{ @$farming->block->name }}</td>
                                    <td class="Action">
                                        @can('edit farmering profile')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="{{route('farmer.farming_registration.edit',$farming->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('delete farmering profile')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['farmer.farming_registration.destroy', $farming->id],'id'=>'delete-form-'.$farming->id]) !!}
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
