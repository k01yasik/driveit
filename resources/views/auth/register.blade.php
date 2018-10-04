@extends('layouts.register')

@section('content')
    <div class="login-wrapper">
        <div class="form-caption">
            <h2>{{ __('Register') }}</h2>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Registration') }}">
                @csrf

                <label for="username">{{ __('Username') }}</label>

                <input id="username" type="text" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif

                <label for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <input id="password-confirm" type="password" name="password_confirmation" required>

                <button type="submit" class="button submit-form margin-top-3">{{ __('Register') }}</button>
            </form>
        </div>
    </div>
@endsection