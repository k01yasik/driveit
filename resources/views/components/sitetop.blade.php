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
                <li><a href="https://vk.com/driveitwithme" target="_blank" rel="nofollow"><i class="fab fa-vk"></i></a></li>
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
                    <a id="at-nav-button-logout">Выйти</a>
                </div>
            @else
                <div class="active-sign-in">
                    <a id="at-nav-button">Войти</a>
                </div>
            @endauth
        </div>
    </div>
</div>