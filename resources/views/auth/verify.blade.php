@extends('layouts.empty')

@section('content')
<div class="login-wrapper rounded">
    <div class="form-caption flex flex-h-center-all">
        <h3 class="line-height-1-2">{{ __('Verify Your Email Address') }}</h3>
    </div>
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
    <p>{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="verify-link">{{ __('click here to request another') }}</a>.</p>
</div>
@endsection
