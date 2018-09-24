@extends('layouts.empty')

@section('content')
    <div class="login-wrapper">
        <div class="form-caption">
            <h2>{{ __('Reset Password') }}</h2>
        </div>

        <div class="form-body">
            @if (session('status'))
                <div role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                @csrf


                <label for="email">{{ __('E-Mail Address') }}</label>


                <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

                <button type="submit" class="button submit-form margin-top-3">
                    {{ __('Send Password Reset Link') }}
                </button>

            </form>
        </div>
    </div>
@endsection
