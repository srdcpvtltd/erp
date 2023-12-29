<div class="table-responsive mt-2">
    <table class="table datatable">
        <thead>
        <tr>
            <th>{{__('Type')}}</th>
            <th>{{__('Farmer Name')}}</th>
            <th>{{__('Registration No.')}}</th>
            <th>{{__('Agreement No.')}}</th>
            <th>{{__('Date')}}</th>
            <th>{{__('Amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($security_deposits as $security_deposit)
            <tr class="font-style">
                <td>{{ @$security_deposit->type}}</td>
                <td>{{ @$security_deposit->farming->name}}</td>
                <td>{{ $security_deposit->registration_number}}</td>
                <td>{{ $security_deposit->agreement_number}}</td>
                <td>{{ $security_deposit->date }}</td>
                <td>{{ $security_deposit->amount }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>