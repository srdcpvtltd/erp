@extends('layouts.admin')
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('page-title')
    {{__('Language')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Language')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Language')}}</li>
@endsection
@push('script-page')
    <script>
        $(document).on('change','#disable_lang',function(){
            var val = $(this).prop("checked");
            if(val == true){
                var langMode = 'on';
            }
            else{
                var langMode = 'off';
            }
            $.ajax({
                type:'POST',
                url: "{{route('disablelanguage')}}",
                datType: 'json',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "mode":langMode,
                    "lang":"{{ $currantLang }}"
                },

                success : function(data){
                    console.log(data)
                    show_toastr('success',data.message, 'success')
                }
            });
        });
    </script>
@endpush


@section('action-btn')
    <div class="float-end">
        @if($currantLang != (!empty( $settings['default_language']) ?  $settings['default_language'] : 'en'))
            <div class="action-btn pb-0">
                <div class="form-check form-switch custom-switch-v1 mb-0">
                    <input type="hidden" name="disable_lang" value="off">
                    <input type="checkbox" class="form-check-input input-primary" name="disable_lang" data-bs-placement="top" title="{{ __('Enable/Disable') }}" id="disable_lang" data-bs-toggle="tooltip" {{ !in_array($currantLang,$disabledLang) ? 'checked':'' }} >
                    <label class="form-check-label" for="disable_lang"></label>
                </div>
            </div>

            <div class="action-btn bg-danger ">
                {!! Form::open(['method' => 'DELETE', 'route' => ['lang.destroy', $currantLang]]) !!}
                <a href="#!" class="btn btn-sm btn-danger btn-icon bs-pass-para" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                    <i class="ti ti-trash text-white"></i>
                </a>
                {!! Form::close() !!}
            </div>
        @endif
    </div>

@endsection
@section('content')
    <div class="row">
        <div class="col-xl-2 col-md-3">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush" id="useradd-sidenav">
                    @foreach ($languages as $code => $lang)
                        <a href="{{route('manage.language',[$code])}}" class="list-group-item list-group-item-action border-0
                                  {{($currantLang == $code)?'active':''}}">{{ucfirst($lang)}}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xl-10 col-md-9">
            <div class="p-3 card">
                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                                data-bs-target="#pills-user-1" type="button">{{__('Labels')}}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                                data-bs-target="#pills-user-2" type="button">{{__('Messages')}}</button>
                    </li>

                </ul>
            </div>
            <div class="card card-fluid">
                <div class="card-body" style="position: relative;">
                    <div class="tab-content no-padding" id="myTab2Content">
                        <div class="tab-pane fade show active" id="lang1" role="tabpanel" aria-labelledby="home-tab4">

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pills-user-1" role="tabpanel" aria-labelledby="pills-user-tab-1">
                                    <form method="post" action="{{route('store.language.data',[$currantLang])}}">
                                        @csrf
                                        <div class="row">
                                            @foreach($arrLabel as $label => $value)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="example3cols1Input">{{$label}} </label>
                                                        <input type="text" class="form-control" name="label[{{$label}}]" value="{{$value}}">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-lg-12 text-end">
                                                <button class="btn btn-primary" type="submit">{{ __('Save Changes')}}</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-user-2" role="tabpanel" aria-labelledby="pills-user-tab-2">
                                    <form method="post" action="{{route('store.language.data',[$currantLang])}}">
                                        @csrf
                                        <div class="row">
                                            @foreach($arrMessage as $fileName => $fileValue)
                                                <div class="col-lg-12">
                                                    <h5>{{ucfirst($fileName)}}</h5>
                                                </div>
                                                @foreach($fileValue as $label => $value)
                                                    @if(is_array($value))
                                                        @foreach($value as $label2 => $value2)
                                                            @if(is_array($value2))
                                                                @foreach($value2 as $label3 => $value3)
                                                                    @if(is_array($value3))
                                                                        @foreach($value3 as $label4 => $value4)
                                                                            @if(is_array($value4))
                                                                                @foreach($value4 as $label5 => $value5)
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label>{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}.{{$label4}}.{{$label5}}</label>
                                                                                            <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}][{{$label4}}][{{$label5}}]" value="{{$value5}}">
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group">
                                                                                        <label>{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}.{{$label4}}</label>
                                                                                        <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}][{{$label4}}]" value="{{$value4}}">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label>{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}</label>
                                                                                <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}]" value="{{$value3}}">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>{{$fileName}}.{{$label}}.{{$label2}}</label>
                                                                        <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}]" value="{{$value2}}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>{{$fileName}}.{{$label}}</label>
                                                                <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}]" value="{{$value}}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <button class="btn btn-primary" type="submit">{{ __('Save Changes')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

