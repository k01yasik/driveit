<div class="sitetop">
    <div class="container">
        <div class="row">
            <div class="col s12 m6 l3 v-h-3 flex">
                <div class="logo"><a href="{{url('/')}}">web-rookie.<span>ru</span></a></div>
            </div>
            <div class="col s12 m6 l2 v-h-3 flex flex-v-center flex-j-end-m col-last-m">
                <ul class="social-button">
                    <li>
                        <a href="https://vk.com/driveitwithme" target="_blank" rel="noopener noreferrer nofollow">
                            <svg class="svg-vk" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.17 14.17">
                                <g id="vk">
                                    <rect fill="#FFFFFF" width="14.17" height="14.17" rx="3"/>
                                    <path id="vk-2" data-name="vk" fill="#573ea4" d="M12.52,4.3h-2.4S9.27,6.48,8.27,7c-.71-.47.17-2.1-.35-2.68-.36-.4-2.58-.29-2.66.22.25.08.48.15.58.36C6.08,5.41,6,7,5.62,7S5.15,6.66,5,6.46a7.18,7.18,0,0,1-.48-.7c-.18-.31-.83-1.51-.83-1.51H1.65A27.42,27.42,0,0,0,2.86,6.91C3.89,8.64,5.05,10.43,8,10c.18-.5,0-1.22.54-1.25.29,0,.51.32.67.51a3.86,3.86,0,0,0,.5.55,2,2,0,0,0,1.5.29c.6,0,1.22.13,1.31-.29S12,8.9,11.75,8.64s-.93-.72-1-1.12.73-1.2,1-1.51A7.28,7.28,0,0,0,12.52,4.3Z"/>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/groups/745210485639351/" target="_blank" rel="noopener noreferrer nofollow">
                            <svg version="1.1" class="svg-fb" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 90 90" style="enable-background:new 0 0 90 90;" xml:space="preserve">
                            <g>
                                <path d="M90,15.001C90,7.119,82.884,0,75,0H15C7.116,0,0,7.119,0,15.001v59.998
                                C0,82.881,7.116,90,15.001,90H45V56H34V41h11v-5.844C45,25.077,52.568,16,61.875,16H74v15H61.875C60.548,31,59,32.611,59,35.024V41
                                h15v15H59v34h16c7.884,0,15-7.119,15-15.001V15.001z"></path>
                            </g>
                        </svg>
                        </a>
                    </li>
                    <li><a href="https://twitter.com/driveitwithme" target="_blank" rel="noopener noreferrer nofollow">
                            <svg version="1.1" class="svg-twitter" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 486.392 486.392" style="enable-background:new 0 0 486.392 486.392;" xml:space="preserve">
                            <g>
                                <path d="M395.193,0H91.198C40.826,0,0,40.826,0,91.198v303.995c0,50.372,40.826,91.198,91.198,91.198
                                h303.995c50.372,0,91.198-40.827,91.198-91.198V91.198C486.392,40.826,445.565,0,395.193,0z M364.186,188.598l0.182,7.752
                                c0,79.16-60.221,170.359-170.359,170.359c-33.804,0-65.268-9.91-91.776-26.904c4.682,0.547,9.454,0.851,14.288,0.851
                                c28.059,0,53.868-9.576,74.357-25.627c-26.204-0.486-48.305-17.814-55.935-41.586c3.678,0.669,7.387,1.034,11.278,1.034
                                c5.472,0,10.761-0.699,15.777-2.067c-27.39-5.533-48.031-29.7-48.031-58.701v-0.76c8.086,4.499,17.297,7.174,27.116,7.509
                                c-16.051-10.731-26.63-29.062-26.63-49.825c0-10.974,2.949-21.249,8.086-30.095c29.518,36.236,73.658,60.069,123.422,62.562
                                c-1.034-4.378-1.55-8.968-1.55-13.649c0-33.044,26.812-59.857,59.887-59.857c17.206,0,32.771,7.265,43.714,18.908
                                c13.619-2.706,26.448-7.691,38.03-14.531c-4.469,13.984-13.953,25.718-26.326,33.135c12.069-1.429,23.651-4.682,34.382-9.424
                                C386.073,169.659,375.889,180.208,364.186,188.598z"></path>
                            </g>
                        </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col s12 m6 l4 v-h-3 flex flex-v-center flex-j-end-s">
                <div class="search">
                    <form method="GET" action="{{ route('search.index') }}" class="search-form" role="search">
                        @csrf
                        <label for="search" class="no-label">Поиск...</label>
                        <input name="search" id="search" type="text" class="inputSearch" autocomplete="off">
                        <button type="submit" role="search" aria-label="search">
                            <svg version="1.1" class="magnifying" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30.239 30.239" style="enable-background:new 0 0 30.239 30.239;"
                            xml:space="preserve">
                                <g>
                                    <path d="M20.194,3.46c-4.613-4.613-12.121-4.613-16.734,0c-4.612,4.614-4.612,12.121,0,16.735
                                    c4.108,4.107,10.506,4.547,15.116,1.34c0.097,0.459,0.319,0.897,0.676,1.254l6.718,6.718c0.979,0.977,2.561,0.977,3.535,0
                                    c0.978-0.978,0.978-2.56,0-3.535l-6.718-6.72c-0.355-0.354-0.794-0.577-1.253-0.674C24.743,13.967,24.303,7.57,20.194,3.46z
                                    M18.073,18.074c-3.444,3.444-9.049,3.444-12.492,0c-3.442-3.444-3.442-9.048,0-12.492c3.443-3.443,9.048-3.443,12.492,0
                                    C21.517,9.026,21.517,14.63,18.073,18.074z"></path>
                                </g>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="col s12 m6 l3 v-h-3 flex flex-v-center flex-j-end-s flex-j-end-l col-last-m flex-j-end-m">
                <div class="signin-block">
                    @auth
                        <div class="active-sign-in">
                            <a href="/user/{{Auth::user()->username}}" class="profile">Профиль</a>
                            <form class="at-nav-button" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="signout">Выйти</button>
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
    </div>
</div>