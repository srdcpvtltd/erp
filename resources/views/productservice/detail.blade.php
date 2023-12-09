<div class="modal-body">
    <div class="card ">
        <div class="card-body table-border-style full-card">
            <div class="table-responsive">
                {{--                    @if(!$products->isEmpty())--}}
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('Warehouse') }}</th>
                        <th>{{__('Quantity')}}</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($products as $product)
                        @if(!empty($product->warehouse()))
                            <tr>

                                <td>{{ !empty($product->warehouse())?$product->warehouse()->name:'-' }}</td>
                                <td>{{ $product->quantity }}</td>


                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{--                    @else--}}
                {{--                        <div class="mt-2 text-center">--}}
                {{--                            No Warehouse Found!--}}
                {{--                        </div>--}}
                {{--                    @endif--}}
            </div>
        </div>
    </div>
</div>
