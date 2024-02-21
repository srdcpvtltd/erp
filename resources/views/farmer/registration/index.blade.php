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
        @can('create farmer registration')
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
                                <th>{{__('G. Code')}}</th>
                                <th>{{__('Mobile')}}</th>
                                <th>{{__('Age')}}</th>
                                <th>{{__('Gender')}}</th>
                                <th>{{__('Qualification')}}</th>
                                <th>{{__('State')}}</th>
                                <th>{{__('District')}}</th>
                                <th>{{__('Block')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($farmings as $farming)
                                <tr class="font-style">
                                    <td>{{ $farming->name}}</td>
                                    <td>{{ $farming->g_code}}</td>
                                    <td>{{ $farming->mobile}}</td>
                                    <td>{{ $farming->age}}</td>
                                    <td>{{ $farming->gender}}</td>
                                    <td>{{ $farming->qualification}}</td>
                                    <td>{{ @$farming->state->name }}</td>
                                    <td>{{ @$farming->district->name }}</td>
                                    <td>{{ @$farming->block->name }}</td>
                                    <td>
                                        @if( @$farming->is_validate)
                                        <span class="status_badge text-capitalize badge bg-success p-2 px-3 rounded">Validated</span>
                                        @else 
                                        <span class="status_badge text-capitalize badge bg-danger p-2 px-3 rounded">Not Validated</span>
                                        @endif
                                    </td>
                                    <td class="Action">
                                        @if( @$farming->is_validate)
                                            @can('show farmer registration')
                                            <div class="action-btn bg-success ms-2">
                                                <a href="{{route('farmer.farming_registration.show',$farming->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                            @endcan
                                        @else
                                            @can('validate farmer registration')
                                                @if( $farming->created_by != Auth::user()->id)
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="{{route('farmer.farming_registration.validate',$farming->id)}}" data-bs-toggle="tooltip" title="{{__('Validate')}}"  class="mx-3 btn  btn-sm  align-items-center">
                                                        <i class="ti ti-rss text-white"></i>
                                                    </a>
                                                </div>
                                                @endif
                                            @endcan
                                            @can('edit farmer registration')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{route('farmer.farming_registration.edit',$farming->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                            @endcan
                                            @can('delete farmer registration')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['farmer.farming_registration.destroy', $farming->id],'id'=>'delete-form-'.$farming->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                            @endcan
                                        @endif
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
