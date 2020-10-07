@extends('layouts.register')

@section('content')
    <div class="login-wrapper rounded">
        <div class="form-caption flex flex-h-center-all height-3">
            <h2>{{ __('Register') }}</h2>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Registration') }}">
                @csrf
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                <input type="hidden" name="action" value="registration">

                <label for="username">{{ __('Username') }}</label>

                <input id="username" type="text" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span role="alert" class="error-message">{{ $errors->first('username') }}</span>
                @endif

                <label for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span role="alert" class="error-message">{{ $errors->first('email') }}</span>
                @endif

                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span role="alert" class="error-message">{{ $errors->first('password') }}</span>
                @endif

                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <input id="password-confirm" type="password" name="password_confirmation" required>

                <button type="submit" class="button submit-form margin-top-3">{{ __('Register') }}</button>

                @if ($errors->has('recaptcha'))
                    <span role="alert" class="error-message">{{ $errors->first('recaptcha') }}</span>
                @endif
            </form>
            <p class="privacy-policy">
                This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy">Privacy Policy</a>
                and <a href="https://policies.google.com/terms">Terms of Service</a> apply.
            </p>
        </div>
    </div>
@endsection