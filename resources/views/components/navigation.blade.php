<div class="navigation">
    <div class="container menu-back">
        <div class="row">
            <div class="col s12">
                <nav>
                    <x-menu.small-nav-header>Menu</x-menu.small-nav-header>
                    <ul class="first-level">
                        <li class="menuItem {{isset($categoryInput) ? '' : 'active'}}">
                            <x-menu.link :route="route('page.home')">Главная</x-menu.link>
                        </li>
                        <li class="menuItem @isset($categoryInput){{in_array($categoryInput, ['auto', 'auto-reviews', 'auto-repairs', 'car-care', 'car-device', 'auto-tips-for-begining']) ? 'active' : ''}}@endisset">
                            <a href="{{ route('category.show', ['category' => 'auto']) }}">Авто <x-svg.caret /></a>
                            <ul class="hidden">
                                <x-menu.item :route="route('category.show', ['category' => 'auto-reviews'])">Обзоры автомобилей</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'auto-repairs'])">Ремонт автомобиля</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'car-care'])">Уход за автомобилем</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'car-device'])">Устройство автомобиля</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'auto-tips-for-begining'])">Советы начинающим</x-menu.item>
                            </ul>
                        </li>
                        <li class="menuItem @isset($categoryInput){{in_array($categoryInput, ['moto', 'moto-reviews', 'moto-repairs', 'moto-care']) ? 'active' : ''}}@endisset">
                            <a href="{{ route('category.show', ['category' => 'moto']) }}">Мото <x-svg.caret /></a>
                            <ul class="hidden">
                                <x-menu.item :route="route('category.show', ['category' => 'moto-reviews'])">Обзоры мотоциклов</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'moto-repairs'])">Ремонт мотоцикла</x-menu.item>
                                <x-menu.item :route="route('category.show', ['category' => 'moto-care'])">Уход за мотоциклом</x-menu.item>
                            </ul>
                        </li>
                        <li class="menuItem @isset($categoryInput){{$categoryInput === 'law' ? 'active' : ''}}@endisset"><a href="{{ route('category.show', ['category' => 'law']) }}">Право</a></li>
                        <li class="menuItem @isset($categoryInput){{$categoryInput === 'helpful' ? 'active' : ''}}@endisset">
                            <x-menu.link :route="route('category.show', ['category' => 'helpful'])">Полезное</x-menu.link>
                        </li>
                    </ul>
                    <div class="small-first-level">
                        <div class="small-delete-button">
                            <x-svg.delete-menu />
                        </div>
                        <ul>
                            <x-menu.item :route="route('page.home')" class="small-deleted-item">Главная</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'auto'])" class="small-deleted-item">Авто</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'auto-reviews'])" class="small-second-level small-deleted-item">Обзоры автомобилей</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'auto-repairs'])" class="small-second-level small-deleted-item">Ремонт автомобиля</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'car-care'])" class="small-second-level small-deleted-item">Уход за автомобилем</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'car-device'])" class="small-second-level small-deleted-item">Устройство автомобиля</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'auto-tips-for-begining'])" class="small-second-level small-deleted-item">Советы начинающим</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'moto'])" class="small-deleted-item">Мото</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'moto-reviews'])" class="small-second-level small-deleted-item">Обзоры мотоциклов</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'moto-repairs'])" class="small-second-level small-deleted-item">Ремонт мотоцикла</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'moto-care'])" class="small-second-level small-deleted-item">Уход за мотоциклом</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'law'])" class="small-deleted-item">Право</x-menu.item>
                            <x-menu.item :route="route('category.show', ['category' => 'helpful'])" class="small-deleted-item">Полезное</x-menu.item>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>