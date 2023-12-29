<div class="table-responsive  mt-2">
    <table class="table datatable">
        <thead>
        <tr>
            <th>{{__('Farmer Name')}}</th>
            <th>{{__('Registration No.')}}</th>
            <th>{{__('Agreement No')}}</th>
            <th>{{__('Date of Agreement')}}</th>
            <th>{{__('Category')}}</th>
            <th>{{__('Type')}}</th>
            <th>{{__('Price')}}</th>
            <th>{{__('Quantity')}}</th>
            <th>{{__('Amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($loans as $loan)
            <tr class="font-style">
                <td>{{ @$loan->farming->name}}</td>
                <td>{{ $loan->registration_number}}</td>
                <td>{{ $loan->agreement_number}}</td>
                <td>{{ $loan->date}}</td>
                <td>{{ @$loan->category->name}}</td>
                <td>{{ @$loan->type->name}}</td>
                <td>{{ @$loan->price_kg}}</td>
                <td>{{ @$loan->quantity}}</td>
                <td>{{ @$loan->total_amount}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>