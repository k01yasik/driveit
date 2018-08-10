<div class="sitetop-row">
    <div class="sitetop-wrapper">
        <div class="logo"><a href="{{url('/')}}">Driveitwith.<span>me</span></a></div>
        <div class="sitetop-middle">
            <div class="search-block">
                <form class="search-form">
                    <input name="search" type="text" class="inputSearch" value="" autocomplete="off">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <ul class="social-button">
                <li><a href="https://vk.com/driveitwithme" target="_blank" rel="nofollow">
                        <svg version="1.1" id="vk" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 14.171 14.171" style="enable-background:new 0 0 14.171 14.171;" xml:space="preserve">
                            <g>
                                <path d="M13.268,0H0.905C0.405,0,0,0.405,0,0.904v12.363c0,0.499,0.405,0.904,0.905,0.904h12.362
                                c0.499,0,0.904-0.405,0.904-0.904V0.904C14.172,0.404,13.767,0,13.268,0z M11.755,8.635c0.259,0.264,0.821,0.707,0.719,1.158
                                c-0.094,0.414-0.712,0.263-1.312,0.287c-0.685,0.029-1.091,0.044-1.503-0.287C9.465,9.636,9.351,9.45,9.165,9.242
                                C8.996,9.054,8.783,8.717,8.493,8.73C7.972,8.756,8.135,9.482,7.95,9.977c-2.896,0.456-4.059-1.333-5.085-3.069
                                C2.368,6.067,1.65,4.261,1.65,4.261l2.048-0.007c0,0,0.657,1.195,0.831,1.503c0.148,0.262,0.311,0.47,0.479,0.704
                                c0.141,0.194,0.364,0.574,0.608,0.543c0.397-0.051,0.469-1.591,0.223-2.107C5.741,4.688,5.506,4.615,5.263,4.544
                                C5.345,4.026,7.56,3.918,7.918,4.32c0.52,0.584-0.36,2.21,0.352,2.684c1-0.524,1.854-2.718,1.854-2.718l2.398,0.015
                                c0,0-0.375,1.186-0.768,1.712c-0.229,0.308-0.989,0.994-0.959,1.503C10.819,7.919,11.437,8.311,11.755,8.635z"/>
                            </g>
                        </svg>
                    </a>
                </li>
                <li><a href="https://www.facebook.com/groups/745210485639351/" target="_blank" rel="nofollow"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com/driveitwithme" target="_blank" rel="nofollow"><i class="fab fa-twitter-square"></i></a></li>
            </ul>
        </div>
        <div class="sitetop-right">
            @auth
                <div class="button-block">
                    <div class="my-page-block">
                        <a href="/user/{{Auth::user()->name}}">Профиль</a>
                    </div>
                    <form class="at-nav-button" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                </div>
            @else
                <div class="active-sign-in">
                    <a href="{{ route('login') }}" class="signin">Войти</a>
                    <a href="{{ route('register') }}" class="registration">Регистрация</a>
                </div>
            @endauth
        </div>
    </div>
</div>