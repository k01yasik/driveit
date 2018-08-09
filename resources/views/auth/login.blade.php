@extends('layouts.empty')

@section('content')
    <div class="form-caption">
        <h2>{{ __('Login') }}</h2>
    </div>
    <hr>
    <div class="form-body">
        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf

            <label for="username">{{ __('Username') }}</label>

            <input id="username" type="text" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="{{ __('Username') }}" required autofocus>

            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif

            <label for="password">{{ __('Password') }}</label>

            <input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label for="remember">{{ __('Remember Me') }}</label>

            <button type="submit" class="submit-form">{{ __('Login') }}</button>
        </form>
    </div>
    <div class="form-footer">
        <a href="{{ route('login.facebook') }}" class="social-btn" name="facebook">
            <div class="left-block"><i class="fab fa-facebook"></i></div>
            <div class="right-block">Войти через Facebook</div>
        </a>
        <a href="{{ route('login.google') }}" class="social-btn" name="google">
            <div class="left-block"><i class="fab fa-google"></i></div>
            <div class="right-block">Войти через Google</div>
        </a>
        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        <a href="{{ route('register') }}" class="link-right">{{ __('Registration') }}</a>
    </div>
@endsection
