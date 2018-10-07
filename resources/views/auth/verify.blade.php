@extends('layouts.empty')

@section('content')
<div class="login-wrapper">
    <div class="form-caption margin-bottom-5 main-caption"><h3>{{ __('Verify Your Email Address') }}</h3></div>
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
    <div class="login-wrapper-text">{{ __('Before proceeding, please check your email for a verification link.') }}</div>
    <div>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="verify-link">{{ __('click here to request another') }}</a>.</div>
</div>
@endsection
