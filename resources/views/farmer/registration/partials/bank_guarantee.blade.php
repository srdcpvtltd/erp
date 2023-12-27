<div class="table-responsive mt-2">
    <table class="table datatable">
        <thead>
        <tr>
            <th>{{__('Type')}}</th>
            <th>{{__('Farmer Name')}}</th>
            <th>{{__('Farmer ID#')}}</th>
            <th>{{__('Bank')}}</th>
            <th>{{__('Loan Disbursement Date')}}</th>
            <th>{{__('Loan Amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($bank_guarantees as $bank_guarantee)
            <tr class="font-style">
                <td>{{ @$bank_guarantee->type}}</td>
                <td>{{ @$bank_guarantee->farming->name}}</td>
                <td>{{ @$bank_guarantee->farming->farmer_id}}</td>
                <td>{{ $bank_guarantee->bank}}</td>
                <td>{{ $bank_guarantee->date }}</td>
                <td>{{ $bank_guarantee->amount }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>