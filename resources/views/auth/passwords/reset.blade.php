@extends('layouts.empty')

@section('content')
    <div class="login-wrapper rounded">
        <div class="form-caption flex flex-h-center-all height-3">
            <h2>{{ __('Reset Password') }}</h2>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                @csrf

                <label for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <input id="password-confirm" type="password" name="password_confirmation" required>

                <button type="submit" class="button submit-form margin-top-3">
                    {{__('Reset Password')}}
                </button>
            </form>
        </div>
    </div>
@endsection
