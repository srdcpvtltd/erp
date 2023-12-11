@extends('layouts.auth')

@section('page-title')
    {{ __('Reset Password') }}
@endsection

@php
    $settings = Utility::settings();
@endphp

@push('custom-scripts')
@if ($settings['recaptcha_module'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush

@php
    $languages = App\Models\Utility::languages();
@endphp
@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> {{ $languages[$lang] }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach($languages as $code => $language)
                <a href="{{ route('password.request',$code) }}"tabindex="0"
                class="dropdown-item ">
                <span>{{ Str::ucfirst($language) }}</span>
            </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection

@section('content')
<div class="card-body">
    <div class="">
        <h2 class="mb-3 f-w-600">{{__('Reset Password')}}</h2>
        @if(session('status'))
            <p class="mb-4 text-muted">
                {{ session('status') }}
            </p>
        @endif
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="">
            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
                @enderror
            </div>

            @if ($settings['recaptcha_module'] == 'on')
                <div class="form-group mb-3">
                    {!! NoCaptcha::display($settings['cust_darklayout']=='on' ? ['data-theme' => 'dark'] : []) !!}
                    @error('g-recaptcha-response')
                    <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block mt-2">{{ __('Send Password Reset Link') }}</button>
            </div>
            <p class="my-4 text-center">{{__("Back to")}} <a href="{{ route('login') }}" class="text-primary">{{__('Login')}}</a></p>

        </div>
    </form>
</div>
@endsection




