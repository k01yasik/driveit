<div class="navigation-row">
    <div class="navigation-wrapper">
        <nav>
            <noindex>
                <div class="small-nav">
                    <h2>Menu</h2>
                    <div class="small-nav-icon"><i class="fas fa-bars" aria-hidden="true"></i></div>
                </div>
            </noindex>
            <ul class="first-level">
                <li class="menuItem {{Route::currentRouteName() === 'page.home' ? 'active' : ''}}">
                    <a href="{{ route('page.home') }}">Главная</a>
                </li>
                <li class="menuItem">
                    <a href="{{ route('category.show', ['category' => 'auto']) }}">Авто <svg version="1.1" id="caret" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 307.054 307.054" style="enable-background:new 0 0 307.054 307.054;"
                            xml:space="preserve">
                                <g>
                                    <path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201
                                    l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0
                                    l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"/>
                                </g>
                            </svg></a>
                    <ul class="hidden">
                        <li><a href="{{ route('category.show', ['category' => 'auto-reviews']) }}">Обзоры автомобилей</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'auto-repairs']) }}">Ремонт автомобиля</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'car-care']) }}">Уход за автомобилем</a> </li>
                        <li><a href="{{ route('category.show', ['category' => 'car-device']) }}">Устройство автомобиля</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'auto-tips-for-begining']) }}">Советы начинающим</a></li>
                    </ul>
                </li>
                <li class="menuItem">
                    <a href="{{ route('category.show', ['category' => 'moto']) }}">Мото <svg version="1.1" id="caret" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 307.054 307.054" style="enable-background:new 0 0 307.054 307.054;"
                                                   xml:space="preserve">
                                <g>
                                    <path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201
                                    l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0
                                    l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"/>
                                </g>
                            </svg></a>
                    <ul class="hidden">
                        <li><a href="{{ route('category.show', ['category' => 'moto-reviews']) }}">Обзоры мотоциклов</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'moto-repairs']) }}">Ремонт мотоцикла</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'moto-care']) }}">Уход за мотоциклом</a></li>
                    </ul>
                </li>
                <li class="menuItem"><a href="{{ route('category.show', ['category' => 'law']) }}">Право</a></li>
                <li class="menuItem">
                    <a href="{{ route('category.show', ['category' => 'helpful']) }}">Полезное</a>
                </li>
            </ul>
            <noindex>
                <div class="small-first-level">
                    <div class="small-delete-button"><i class="fas fa-times" aria-hidden="true"></i></div>
                    <ul>
                        <li class="small-deleted-item">
                            <a href="{{ route('page.home') }}">Главная</a>
                        </li>
                        <li class="small-deleted-item">
                            <a href="{{ route('category.show', ['category' => 'auto']) }}">Авто</a>
                        </li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'auto-reviews']) }}">Обзоры автомобилей</a></li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'auto-repairs']) }}">Ремонт автомобиля</a></li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'car-care']) }}">Уход за автомобилем</a> </li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'car-device']) }}">Устройство автомобиля</a></li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'auto-tips-for-begining']) }}">Советы начинающим</a></li>
                        <li class="small-deleted-item">
                            <a href="{{ route('category.show', ['category' => 'moto']) }}">Мото</a>
                        </li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'moto-reviews']) }}">Обзоры мотоциклов</a></li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'moto-repairs']) }}">Ремонт мотоцикла</a></li>
                        <li class="small-second-level small-deleted-item"><a href="{{ route('category.show', ['category' => 'moto-care']) }}">Уход за мотоциклом</a></li>
                        <li class="small-deleted-item"><a href="{{ route('category.show', ['category' => 'law']) }}">Право</a></li>
                        <li class="small-deleted-item">
                            <a href="{{ route('category.show', ['category' => 'helpful']) }}">Полезное</a>
                        </li>
                    </ul>
                </div>
            </noindex>
        </nav>
    </div>
</div>