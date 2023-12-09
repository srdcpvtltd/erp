{{ Form::model($bankAccount, array('route' => array('bank-account.update', $bankAccount->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('chart_account_id', __('Account'),['class'=>'form-label']) }}
            {{ Form::select('chart_account_id', $chart_accounts,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('holder_name', __('Bank Holder Name'),['class'=>'form-label']) }}
            {{ Form::text('holder_name',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('bank_name', __('Bank Name'),['class'=>'form-label']) }}
            {{ Form::text('bank_name',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_number', __('Account Number'),['class'=>'form-label']) }}
            {{ Form::text('account_number',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('opening_balance', __('Opening Balance'),['class'=>'form-label']) }}
            {{ Form::number('opening_balance',null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('contact_number', __('Contact Number'),['class'=>'form-label']) }}
            {{ Form::text('contact_number',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('bank_address', __('Bank Address'),['class'=>'form-label']) }}
            {{ Form::textarea('bank_address',null, array('class' => 'form-control','rows'=>3,'required'=>'required')) }}
        </div>
        @if(!$customFields->isEmpty())
            <div class="col-md-12">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
