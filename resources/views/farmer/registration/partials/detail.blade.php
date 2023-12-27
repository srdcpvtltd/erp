<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
        {{ Form::text('name', $farming->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('mobile', __('Mobile'),['class'=>'form-label']) }}
        {{ Form::number('mobile', $farming->mobile, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('country_id', __('Country'),['class'=>'form-label']) }}
            {{ Form::text('country_id', $farming->country->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('state_id', __('State'),['class'=>'form-label']) }}
            {{ Form::text('state_id', $farming->state->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('district_id', __('District'),['class'=>'form-label']) }}
            {{ Form::text('district_id', $farming->district->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('block_id', __('Block'),['class'=>'form-label']) }}
            {{ Form::text('block_id', $farming->block->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('gram_panchyat_id', __('Gram Panchyat'),['class'=>'form-label']) }}
            {{ Form::text('gram_panchyat_id', $farming->gram_panchyat->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('village_id', __('Village'),['class'=>'form-label']) }}
            {{ Form::text('village_id', $farming->village->name, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('post_office', __('Post Office'),['class'=>'form-label']) }}
        {{ Form::text('post_office', $farming->post_office, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('police_station', __('Police Station'),['class'=>'form-label']) }}
        {{ Form::text('police_station', $farming->police_station, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('registration_no', __('Registration No.'),['class'=>'form-label']) }}
        {{ Form::text('registration_no', $farming->registration_no, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('age', __('Age'),['class'=>'form-label']) }}
        {{ Form::number('age', $farming->age, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}
        {{ Form::number('gender', $farming->gender, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}                    
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('qualification', __('Qualification'),['class'=>'form-label']) }}
        {{ Form::text('qualification', $farming->qualification, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('land_holding', __('Land Holding (In Acre)'),['class'=>'form-label']) }}
        {{ Form::text('land_holding', $farming->land_holding, array('class' => 'form-control','step' => '0.01','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('language', __('Language'),['class'=>'form-label']) }}
        {{ Form::text('language', $farming->language, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('sms_mode', __('Sms Mode'),['class'=>'form-label']) }}
        {{ Form::text('sms_mode', $farming->sms_mode, array('class' => 'form-control','required'=>'required','disabled'=>'true')) }}
    </div>
</div>