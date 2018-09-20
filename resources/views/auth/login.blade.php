@extends('layouts.empty')

@section('content')
    <div class="login-wrapper">
        <div class="form-caption">
            <h2>{{ __('Login') }}</h2>
        </div>
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

                <button type="submit" class="submit-form button">{{ __('Login') }}</button>
            </form>
        </div>
        <div class="form-footer">
            <a href="{{ route('login.facebook') }}" class="social-btn" name="facebook">
                <div class="left-block">
                    <svg version="1.1" class="facebook-login-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 90 90" style="enable-background:new 0 0 90 90;" xml:space="preserve">
                        <g>
                            <path d="M90,15.001C90,7.119,82.884,0,75,0H15C7.116,0,0,7.119,0,15.001v59.998
                            C0,82.881,7.116,90,15.001,90H45V56H34V41h11v-5.844C45,25.077,52.568,16,61.875,16H74v15H61.875C60.548,31,59,32.611,59,35.024V41
                            h15v15H59v34h16c7.884,0,15-7.119,15-15.001V15.001z"></path>
                        </g>
                    </svg>
                </div>
                <div class="right-block">Войти через Facebook</div>
            </a>
            <a href="{{ route('login.google') }}" class="social-btn" name="google">
                <div class="left-block">
                    <svg version="1.1" class="google-login-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                        <g>
                            <path d="M234.6,175.95c0-25.5-15.3-76.5-53.55-76.5c-15.3,0-33.15,10.2-33.15,43.35c0,30.6,15.3,73.95,51,73.95
                            C198.9,216.75,234.6,214.2,234.6,175.95z M219.3,300.9c-2.55,0-5.1,0-7.65,0l0,0c-7.65,0-30.6,2.55-45.9,7.649
                            C147.9,313.65,127.5,326.4,127.5,351.9c0,28.05,25.5,56.1,76.5,56.1c38.25,0,61.2-25.5,61.2-51
                            C265.2,339.15,252.45,326.4,219.3,300.9z M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51
                            V51C510,22.95,487.05,0,459,0z M181.05,438.6c-71.4,0-104.55-40.8-104.55-76.5c0-12.75,2.55-40.8,38.25-61.199
                            c20.4-12.75,45.9-20.4,79.05-22.95c-5.1-5.101-7.65-12.75-7.65-25.5c0-5.1,0-7.65,2.55-12.75h-10.2c-51,0-81.6-38.25-81.6-76.5
                            c0-43.35,33.15-91.8,104.55-91.8h107.1l-7.649,7.65L283.05,96.9l-2.55,2.55h-17.85c10.199,10.2,22.949,28.05,22.949,56.1
                            c0,35.7-17.85,53.55-40.8,68.85c-5.1,2.55-10.2,10.2-10.2,17.85s5.1,12.75,10.2,15.3c2.55,2.55,7.65,5.101,12.75,7.65
                            c20.4,15.3,48.45,33.149,48.45,73.95C306,385.05,272.85,438.6,181.05,438.6z M433.5,255h-51v51H357v-51h-51v-25.5h51v-51h25.5v51
                            h51V255z"></path>
                        </g>
                    </svg>
                </div>
                <div class="right-block">Войти через Google</div>
            </a>
            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            <a href="{{ route('register') }}" class="link-right">{{ __('Registration') }}</a>
        </div>
    </div>
@endsection
