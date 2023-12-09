{{ Form::model($warehouse, array('route' => array('warehouse.update', $warehouse->id), 'method' => 'PUT')) }}

<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if($settings['ai_chatgpt_enable'] == 'on')
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['warehouse']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="form-group col-md-12">

            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
            @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city',__('City'),array('class'=>'form-label')) }}
            {{Form::text('city',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city_zip',__('Zip Code'),array('class'=>'form-label')) }}
            {{Form::text('city_zip',null,array('class'=>'form-control'))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Edit')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
