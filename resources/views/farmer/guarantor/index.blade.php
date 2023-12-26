@extends('layouts.admin')
@section('page-title')
    {{__('Farming Guarantor')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Farming Guarantor')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create farmer guarantor')
        <a href="{{ route('farmer.guarantor.create') }}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Farmer Name')}}</th>
                                <th>{{__('Registration No.')}}</th>
                                <th>{{__('Age')}}</th>
                                <th>{{__('Father Name')}}</th>
                                <th>{{__('Post')}}</th>
                                <th>{{__('Post Office')}}</th>
                                <th>{{__('Police Station')}}</th>
                                <th>{{__('District')}}</th>
                                <th>{{__('Block')}}</th>
                                <th>{{__('Village')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($guarantors as $guarantor)
                                <tr class="font-style">
                                    <td>{{ $guarantor->name}}</td>
                                    <td>{{ @$guarantor->farming->name}}</td>
                                    <td>{{ $guarantor->registration_number}}</td>
                                    <td>{{ $guarantor->age}}</td>
                                    <td>{{ $guarantor->father_name}}</td>
                                    <td>{{ $guarantor->post_office}}</td>
                                    <td>{{ $guarantor->police_station}}</td>
                                    <td>{{ @$guarantor->district->name }}</td>
                                    <td>{{ @$guarantor->block->name }}</td>
                                    <td>{{ @$guarantor->village->name }}</td>
                      
                                    <td class="Action">
                                        @can('edit farmer guarantor')
                                        <div class="action-btn bg-info ms-2">
                                            <a href="{{route('farmer.guarantor.edit',$guarantor->id)}}" class="mx-3 btn btn-sm  align-items-center">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        @can('delete farmer guarantor')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['farmer.guarantor.destroy', $guarantor->id],'id'=>'delete-form-'.$guarantor->id]) !!}
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
