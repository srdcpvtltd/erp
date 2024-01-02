@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_favicon=Utility::getValByName('company_favicon');
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    $setting = \App\Models\Utility::settings();
    $color = 'theme-3';
    if (!empty($setting['color'])) {
        $color = $setting['color'];
    }
    $getseo= App\Models\Utility::getSeoSetting();
    $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
    $metsdesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';
@endphp
    <!DOCTYPE html>
<html lang="en" dir="{{$SITE_RTL == 'on'?'rtl':''}}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<head>
    <title>BANK GUARANTEE</title>
    <meta name="title" content="{{$metatitle}}">
    <meta name="description" content="{{$metsdesc}}">



    <script src="{{ asset('js/html5shiv.js') }}"></script>

{{--    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>--}}

    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="url" content="{{ url('').'/'.config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <!-- Favicon icon -->
{{--    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon"/>--}}
    <!-- Calendar-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif


    @if($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style">
    @endif


    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" >

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('css/custom-dark.css') }}" >
    @endif

    @stack('css-page')
</head>
<body class="{{ $color }}">


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>
                                <u>
                                    OFFICE OF THE ASKA COOP. SUGAR INDUSTRIES LTD., NUAGAM, ASKA
                                </u>
                            </h1>         
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-4">  
                        </div>
                        <div class="col-4 text-center">  
                            
                            <h3>TIE UP</h3>
                            <h3><u>AGREEMENT</u></h3>
                            <h3><u>(To be stamped)</u></h3>
                        </div>
                        <div class="col-4 text-right">  
                            
                            <h3>Form-l</h3>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-8">  
                            <p style="font-weight:900!important;">
                                The Branch Manager <br>
                                {{$payment->bank}} <br>
                                Kotinada
                            </p>
                        </div>
                        <div class="col-4">  
                            <p style="font-weight:900!important;">
                                Place: A.C.S.I Ltd., <br>
                                Nuagam, Aska <br>
                                Date: {{$payment->date}} <br>
                            </p>
                        </div>
                        <p style="font-weight:900!important;">Dear Sir,</p>
                        <div class="col-12">
                            <p style="font-weight:900!important;">
                                In consideration of the {{$payment->bank}} having one of its branch at Kotinada at our request 
                                agreed to provide necessary finance by way of Cash Credit and/or Term loan to cultivator-members of our society/registered
                                suppliers of sugarcane to us details of such farmers togeter with amount lent by you being 
                                periodically furnished to us to enable them to take up the cultvation of SUGARCANE in proper manner 
                                and/or to enable them to purchase motor truck and/or tractor and/or bullock cart and/or I.P sets as the case may be, 
                                we the Aska Cooperative Sugar Industries Ltd., having our registered office at Nuagam (Aska) do hereby so as to bind 
                                our successors and assigns irrevoably, agree and undertake to deduct from the sale proceeds of the payable by us in 
                                respect of the said motor truck and tractor and/or bullock cart as the case may be the amounts due and becoming due 
                                to you by each and every one tof them along with interest and such other money as may  be directed by you and pay the 
                                same to you before any deduction and/or payments are made by us there from for any other purpose including our dues 
                                if any other financing agency including any co-operative bank/socirety etc. We futher agree that the undertaking here 
                                in contained shall remain in continusing form until our release by you. We lastly agree and udetake to execute such 
                                other document(s) as may be required by you.
                            </p>
                        </div>
                        <div class="col-6">
                            <p style="font-weight:900!important;">
                                Name of Farmer: <u>{{@$payment->farming->name}}</u>
                            </p>
                        </div>
                        <div class="col-6">
                            <p style="font-weight:900!important;">
                                Father Name: <u>{{@$payment->farming->name}}</u>
                            </p>
                        </div>
                        <div class="col-12">
                            <p style="font-weight:900!important;">
                                Address: <u>
                                    {{@$payment->farming->village->name .', '. @$payment->farming->gram_panchyat->name .', '.@$payment->farming->block->name .', '.@$payment->farming->district->name .', '.@$payment->farming->state->name .', '.@$payment->farming->country->name}}
                                </u>
                            </p>
                        </div>
                        <div class="col-8">  
                        </div>
                        <div class="col-4">  
                            <p style="font-weight:900!important;">
                                Your faithfully, 
                                <br>
                                <br>
                                <br>
                                <br>
                                Secretary 
                            </p>
                        </div>
                        <div class="col-7"></div>
                        <div class="col-5">
                            <p style="font-weight:900!important;">
                                Aska Coop.Sugar Industries Ltd., Aska
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
