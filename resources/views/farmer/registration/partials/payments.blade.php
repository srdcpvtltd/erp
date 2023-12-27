<div class="table-responsive">
    <table class="table datatable">
        <thead>
        <tr>
            <th>{{__('Farmer Name')}}</th>
            <th>{{__('Registration No.')}}</th>
            <th>{{__('Agreement No.')}}</th>
            <th>{{__('Date')}}</th>
            <th>{{__('Amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($payments as $payment)
            <tr class="font-style">
                <td>{{ @$payment->farming->name}}</td>
                <td>{{ $payment->registration_number}}</td>
                <td>{{ $payment->agreement_number}}</td>
                <td>{{ $payment->date }}</td>
                <td>{{ $payment->amount }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>