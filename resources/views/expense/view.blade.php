@extends('layouts.admin')
@section('page-title')
    {{__('Expense Detail')}}
@endsection
@push('script-page')
    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })



    </script>
@endpush
@php
    $settings = Utility::settings();
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('expense.index')}}">{{__('Expense')}}</a></li>
    <li class="breadcrumb-item">{{ Auth::user()->expenseNumberFormat($expense->bill_id) }}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4>{{__('Expense')}}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">{{ Auth::user()->expenseNumberFormat($expense->bill_id) }}</h4>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>




                            <div class="row">

                                @if($expense->user_type == 'employee')
                                    <div class="col-5">
                                        <small class="font-style">
                                            <strong>{{__('Employee Detail')}} :</strong><br>
                                            @if(!empty($user->name))
                                                {{!empty($user->name)?$user->name:''}}<br>
                                                {{!empty($user->email)?$user->email:''}}<br>
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>

                                @elseif($expense->user_type == 'customer')
                                    <div class="col-5">
                                        <small class="font-style">
                                            <strong>{{__('Billed To')}} :</strong><br>
                                            @if(!empty($user->billing_name))
                                                {{!empty($user->billing_name)?$user->billing_name:''}}<br>
                                                {{!empty($user->billing_address)?$user->billing_address:''}}<br>
                                                {{!empty($user->billing_city)?$user->billing_city:'' .', '}}<br>
                                                {{!empty($user->billing_state)?$user->billing_state:'',', '}},
                                                {{!empty($user->billing_zip)?$user->billing_zip:''}}<br>
                                                {{!empty($user->billing_country)?$user->billing_country:''}}<br>
                                                {{!empty($user->billing_phone)?$user->billing_phone:''}}<br>
                                                @if($settings['vat_gst_number_switch'] == 'on')
                                                    <strong>{{__('Tax Number ')}} : </strong>{{!empty($user->tax_number)?$user->tax_number:''}}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    @if(App\Models\Utility::getValByName('shipping_display')=='on')
                                        <div class="col-4">
                                            <small>
                                                <strong>{{__('Shipped To')}} :</strong><br>
                                                @if(!empty($user->shipping_name))
                                                    {{!empty($user->shipping_name)?$user->shipping_name:''}}<br>
                                                    {{!empty($user->shipping_address)?$user->shipping_address:''}}<br>
                                                    {{!empty($user->shipping_city)?$user->shipping_city:'' . ', '}}<br>
                                                    {{!empty($user->shipping_state)?$user->shipping_state:'' .', '}},
                                                    {{!empty($user->shipping_zip)?$user->shipping_zip:''}}<br>
                                                    {{!empty($user->shipping_country)?$user->shipping_country:''}}<br>
                                                    {{!empty($user->shipping_phone)?$user->shipping_phone:''}}<br>
                                                @else
                                                    -
                                                @endif
                                            </small>
                                        </div>
                                    @endif

                                @else
                                    <div class="col-5">
                                        <small class="font-style">
                                            <strong>{{__('Billed To')}} :</strong><br>
                                            @if(!empty($user->billing_name))
                                                {{!empty($user->billing_name)?$user->billing_name:''}}<br>
                                                {{!empty($user->billing_address)?$user->billing_address:''}}<br>
                                                {{!empty($user->billing_city)?$user->billing_city:'' .', '}}<br>
                                                {{!empty($user->billing_state)?$user->billing_state:'',', '}},
                                                {{!empty($user->billing_zip)?$user->billing_zip:''}}<br>
                                                {{!empty($user->billing_country)?$user->billing_country:''}}<br>
                                                {{!empty($user->billing_phone)?$user->billing_phone:''}}<br>
                                                @if($settings['vat_gst_number_switch'] == 'on')
                                                    <strong>{{__('Tax Number')}} : </strong>{{!empty($user->tax_number)?$user->tax_number:''}}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    @if(App\Models\Utility::getValByName('shipping_display')=='on')
                                        <div class="col-4">
                                            <small>
                                                <strong>{{__('Shipped To')}} :</strong><br>
                                                @if(!empty($user->shipping_name))
                                                    {{!empty($user->shipping_name)?$user->shipping_name:''}}<br>
                                                    {{!empty($user->shipping_address)?$user->shipping_address:''}}<br>
                                                    {{!empty($user->shipping_city)?$user->shipping_city:'' . ', '}}<br>
                                                    {{!empty($user->shipping_state)?$user->shipping_state:'' .', '}},
                                                    {{!empty($user->shipping_zip)?$user->shipping_zip:''}}<br>
                                                    {{!empty($user->shipping_country)?$user->shipping_country:''}}<br>
                                                    {{!empty($user->shipping_phone)?$user->shipping_phone:''}}<br>
                                                @else
                                                    -
                                                @endif
                                            </small>
                                        </div>
                                    @endif
                                @endif



                                <div class="col">
                                    <small>
                                        <strong>{{__('Payment Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($expense->bill_date)}}<br><br>
                                    </small>

                                </div>

                            </div>
                            <div class="row">

                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{__('Status')}} : </strong><br>
                                            <span class="badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$expense->status]) }}</span>

                                    </small>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-bold mb-2">{{__('Product Summary')}}</div>
                                    <small class="mb-2">{{__('All items here cannot be deleted.')}}</small>
                                    <div class="table-responsive mt-3">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark">{{__('Product')}}</th>
                                                <th class="text-dark">{{__('Quantity')}}</th>
                                                <th class="text-dark">{{__('Rate')}}</th>
                                                <th class="text-dark">{{__('Discount')}}</th>
                                                <th class="text-dark">{{__('Tax')}}</th>
                                                <th class="text-dark">{{__('Chart Of Account')}}</th>
                                                <th class="text-dark">{{__('Account Amount')}}</th>
                                                <th class="text-dark">{{__('Description')}}</th>
                                                <th class="text-end text-dark" width="12%">{{__('Price')}}<br>
                                                    <small class="text-danger font-weight-bold">{{__('after tax & discount')}}</small>
                                                </th>
                                                <th></th>
                                            </tr>
                                            @php
                                                $totalQuantity=0;
                                               $totalRate=0;
                                               $totalTaxPrice=0;
                                               $totalDiscount=0;
                                               $taxesData=[];
                                            @endphp



                                            @foreach($items as $key =>$item)

                                                @if(!empty($item->tax))
                                                    @php
                                                        $taxes=App\Models\Utility::tax($item->tax);
                                                        $totalQuantity+=$item->quantity;
                                                        $totalRate+=$item->price;
                                                        $totalDiscount+=$item->discount;
                                                        foreach($taxes as $taxe){
                                                            $taxDataPrice=App\Models\Utility::taxRate($taxe->rate,$item->price,$item->quantity,$item->discount);
                                                            if (array_key_exists($taxe->name,$taxesData))
                                                            {
                                                                $taxesData[$taxe->name] = $taxesData[$taxe->name]+$taxDataPrice;
                                                            }
                                                            else
                                                            {
                                                                $taxesData[$taxe->name] = $taxDataPrice;
                                                            }
                                                        }
                                                    @endphp
                                                @endif

                                                @if(!empty($item->product_id))
                                                        <tr>
                                                            <td>{{$key+1}}</td>

                                                            <td>{{!empty($item->product)?$item->product->name:'-'}}</td>
                                                            @php
                                                            $unit = !empty($item->product)?$item->product->unit_id :'-';
                                                            $unitName = App\Models\ProductServiceUnit::find($unit);
                                                        @endphp
                                                        <td>{{$item->quantity . ' (' . $unitName->name . ')'}}</td>
                                                            <td>{{\Auth::user()->priceFormat($item->price)}}</td>
                                                            <td>{{\Auth::user()->priceFormat($item->discount)}}</td>
                                                            <td>
                                                                @if(!empty($item->tax))
                                                                    <table>
                                                                        @php
                                                                            $totalTaxRate = 0;
                                                                        @endphp
                                                                        @foreach($taxes as $tax)

                                                                            @php
                                                                                $taxPrice=App\Models\Utility::taxRate($tax->rate,$item->price,$item->quantity,$item->discount) ;
                                                                                $totalTaxPrice+=$taxPrice;
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{$tax->name .' ('.$tax->rate .'%)'}}</td>
                                                                                <td>{{\Auth::user()->priceFormat($taxPrice)}}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>

                                                            @php
                                                                $chartAccount = \App\Models\ChartOfAccount::account($item->chart_account_id);
                                                            @endphp

                                                            <td>{{!empty($chartAccount) ? $chartAccount->name : '-'}}</td>
                                                            <td>{{\Auth::user()->priceFormat($item->amount)}}</td>

                                                            <td>{{!empty($item->description)?$item->description:'-'}}</td>

                                                            <td class="text-end">{{\Auth::user()->priceFormat(($item->price * $item->quantity - $item->discount) + $totalTaxPrice)}}</td>
                                                            <td></td>
                                                        </tr>
                                                    @else
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        @php
                                                            $chartAccount = \App\Models\ChartOfAccount::account($item['chart_account_id']);
                                                        @endphp
                                                        <td>{{!empty($chartAccount) ? $chartAccount->name : '-'}}</td>
                                                        <td>{{\Auth::user()->priceFormat($item['amount'])}}</td>
                                                        <td>-</td>
                                                        <td class="text-end">{{\Auth::user()->priceFormat($item['amount'])}}</td>
                                                        <td></td>


                                                    </tr>

                                                @endif


                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>{{__('Total')}}</b></td>
                                                <td><b>{{$totalQuantity}}</b></td>
                                                <td><b>{{\Auth::user()->priceFormat($totalRate)}}</b></td>
                                                <td><b>{{\Auth::user()->priceFormat($totalDiscount)}}</b></td>
                                                <td><b>{{\Auth::user()->priceFormat($totalTaxPrice)}}</b></td>
                                                <td></td>
                                                <td><b>{{\Auth::user()->priceFormat($expense->getAccountTotal())}}</b></td>

                                            </tr>
                                            <tr>
                                                <td colspan="8"></td>
                                                <td class="text-end"><b>{{__('Sub Total')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat($expense->getSubTotal())}}</td>
                                            </tr>

                                                <tr>
                                                    <td colspan="8"></td>
                                                    <td class="text-end"><b>{{__('Discount')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat($expense->getTotalDiscount())}}</td>
                                                </tr>

                                            @if(!empty($taxesData))
                                                @foreach($taxesData as $taxName => $taxPrice)
                                                    <tr>
                                                        <td colspan="8"></td>
                                                        <td class="text-end"><b>{{$taxName}}</b></td>
                                                        <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="8"></td>
                                                <td class="blue-text text-end"><b>{{__('Total')}}</b></td>
                                                <td class="blue-text text-end">{{\Auth::user()->priceFormat($expense->getTotal())}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="8"></td>
                                                <td class="text-end"><b>{{__('Paid')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat(($expense->getTotal()-$expense->getDue())-($expense->billTotalDebitNote()))}}</td>
                                            </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
