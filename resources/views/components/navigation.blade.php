<div class="navigation-row">
    <div class="navigation-wrapper">
        <nav>

            <div class="small-nav">
                <div class="small-nav-caption">Menu</div>
                <div class="menu-icon-svg">
                    <svg version="1.1" class="reorder-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 438.533 438.533" style="enable-background:new 0 0 438.533 438.533;"
                    xml:space="preserve">
                        <g>
                            <g>
                            <path d="M420.265,328.897H18.274c-4.952,0-9.235,1.813-12.851,5.428C1.807,337.938,0,342.224,0,347.172v36.548
                            c0,4.949,1.807,9.23,5.424,12.848c3.619,3.613,7.902,5.424,12.851,5.424h401.991c4.948,0,9.229-1.811,12.847-5.424
                            c3.614-3.617,5.421-7.898,5.421-12.848v-36.548c0-4.948-1.8-9.233-5.421-12.847C429.495,330.711,425.217,328.897,420.265,328.897z
                            "></path>
                            <path d="M433.112,41.968c-3.617-3.617-7.898-5.426-12.847-5.426H18.274c-4.952,0-9.235,1.809-12.851,5.426
                            C1.807,45.583,0,49.866,0,54.813V91.36c0,4.949,1.807,9.229,5.424,12.847c3.619,3.618,7.902,5.424,12.851,5.424h401.991
                            c4.948,0,9.229-1.807,12.847-5.424c3.614-3.617,5.421-7.898,5.421-12.847V54.813C438.533,49.866,436.729,45.583,433.112,41.968z"
                            ></path>
                            <path d="M420.265,182.72H18.274c-4.952,0-9.235,1.809-12.851,5.426C1.807,191.761,0,196.044,0,200.992v36.547
                            c0,4.948,1.807,9.236,5.424,12.847c3.619,3.614,7.902,5.428,12.851,5.428h401.991c4.948,0,9.229-1.813,12.847-5.428
                            c3.614-3.61,5.421-7.898,5.421-12.847v-36.547c0-4.948-1.807-9.231-5.421-12.847C429.495,184.528,425.217,182.72,420.265,182.72z"
                            ></path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            <ul class="first-level">
                <li class="menuItem {{isset($categoryInput) ? '' : 'active'}}">
                    <a href="{{ route('page.home') }}">Главная</a>
                </li>
                <li class="menuItem @isset($categoryInput){{in_array($categoryInput, ['auto', 'auto-reviews', 'auto-repairs', 'car-care', 'car-device', 'auto-tips-for-begining']) ? 'active' : ''}}@endisset">
                    <a href="{{ route('category.show', ['category' => 'auto']) }}">Авто <svg version="1.1" class="caret" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 307.054 307.054" style="enable-background:new 0 0 307.054 307.054;"
                            xml:space="preserve">
                                <g>
                                    <path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201
                                    l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0
                                    l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"></path>
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
                <li class="menuItem @isset($categoryInput){{in_array($categoryInput, ['moto', 'moto-reviews', 'moto-repairs', 'moto-care']) ? 'active' : ''}}@endisset">
                    <a href="{{ route('category.show', ['category' => 'moto']) }}">Мото <svg version="1.1" class="caret" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 307.054 307.054" style="enable-background:new 0 0 307.054 307.054;"
                                                   xml:space="preserve">
                                <g>
                                    <path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201
                                    l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0
                                    l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"></path>
                                </g>
                            </svg></a>
                    <ul class="hidden">
                        <li><a href="{{ route('category.show', ['category' => 'moto-reviews']) }}">Обзоры мотоциклов</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'moto-repairs']) }}">Ремонт мотоцикла</a></li>
                        <li><a href="{{ route('category.show', ['category' => 'moto-care']) }}">Уход за мотоциклом</a></li>
                    </ul>
                </li>
                <li class="menuItem @isset($categoryInput){{$categoryInput === 'law' ? 'active' : ''}}@endisset"><a href="{{ route('category.show', ['category' => 'law']) }}">Право</a></li>
                <li class="menuItem @isset($categoryInput){{$categoryInput === 'helpful' ? 'active' : ''}}@endisset">
                    <a href="{{ route('category.show', ['category' => 'helpful']) }}">Полезное</a>
                </li>
            </ul>

            <div class="small-first-level">
                <div class="small-delete-button">
                    <svg version="1.1" class="delete-menu-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"
                    xml:space="preserve">
                        <g>
                            <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
                            c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
                            c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
                            c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
                            s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>
                        </g>
                    </svg>
                </div>
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

        </nav>
    </div>
</div>