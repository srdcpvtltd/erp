{{Form::open(array('url'=>'announcement','method'=>'post'))}}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if($settings['ai_chatgpt_enable'] == 'on')
        <div class="text-end">
            <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['announcement']) }}"
               data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
                <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
            </a>
        </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('title',__('Announcement Title'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Announcement Title')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('branch_id',__('Branch'),['class'=>'form-label'])}}
                <select class="form-control select" name="branch_id" id="branch_id" placeholder="Select Branch">
                    <option value="">{{__('Select Branch')}}</option>
                    <option value="0">{{__('All Branch')}}</option>
                    @foreach($branch as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
                <select class="form-control select" name="department_id[]" id="department_id" placeholder="Select Department" >
                    <option value="">{{__('Select Department')}}</option>

                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('employee_id',__('Employee'),['class'=>'form-label'])}}
                <select class="form-control select" name="employee_id[]" id="employee_id" placeholder="Select Employee" >
                    <option value="">{{__('Select Employee')}}</option>

                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Announcement start Date'),['class'=>'form-label'])}}
                {{Form::date('start_date',null,array('class'=>'form-control '))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('Announcement End Date'),['class'=>'form-label'])}}
                {{Form::date('end_date',null,array('class'=>'form-control '))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Announcement Description'),['class'=>'form-label'])}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Announcement Title')))}}
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


<script>

    //Branch Wise Deapartment Get
    $(document).ready(function () {
        var b_id = $('#branch_id').val();
        getDepartment(b_id);
    });

    $(document).on('change', 'select[name=branch_id]', function () {
        var branch_id = $(this).val();
        getDepartment(branch_id);
    });

    function getDepartment(bid) {

        $.ajax({
            url: '{{route('announcement.getdepartment')}}',
            type: 'POST',
            data: {
                "branch_id": bid, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {
                $('#department_id').empty();
                $('#department_id').append('<option value="">{{__('Select Department')}}</option>');

                $('#department_id').append('<option value="0"> {{__('All Department')}} </option>');
                $.each(data, function (key, value) {
                    $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(document).on('change', '#department_id', function () {
        var department_id = $(this).val();
        getEmployee(department_id);
    });

    function getEmployee(did) {

        $.ajax({
            url: '{{route('announcement.getemployee')}}',
            type: 'POST',
            data: {
                "department_id": did, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {

                $('#employee_id').empty();
                $('#employee_id').append('<option value="">{{__('Select Employee')}}</option>');
                $('#employee_id').append('<option value="0"> {{__('All Employee')}} </option>');

                $.each(data, function (key, value) {
                    $('#employee_id').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }
</script>

