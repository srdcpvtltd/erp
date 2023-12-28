<div class="table-responsive">
    <table class="table datatable">
        <thead>
        <tr>
            <th>{{__('Guarantor Name')}}</th>
            <th>{{__('Registration No.')}}</th>
            <th>{{__('Age')}}</th>
            <th>{{__('Father Name')}}</th>
            <th>{{__('Post Office')}}</th>
            <th>{{__('Police Station')}}</th>
            <th>{{__('District')}}</th>
            <th>{{__('Block')}}</th>
            <th>{{__('Village')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($guarantors as $guarantor)
            <tr class="font-style">
                <td>{{ $guarantor->name}}</td>
                <td>{{ $guarantor->registration_number}}</td>
                <td>{{ $guarantor->age}}</td>
                <td>{{ $guarantor->father_name}}</td>
                <td>{{ $guarantor->post_office}}</td>
                <td>{{ $guarantor->police_station}}</td>
                <td>{{ @$guarantor->district->name }}</td>
                <td>{{ @$guarantor->block->name }}</td>
                <td>{{ @$guarantor->village->name }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>