<div class="carousel-row">
    <div class="carousel-wrapper">
        <ul class="rslides">
            <li>
                <a href="{{ route('category.show', ['category' => 'auto']) }}">
                    <picture>
                        <source media="(max-width: 375px)" srcset="{{asset('storage/Bzdykin/carousel/bmw-m6-375w.webp')}}">
                        <source media="(max-width: 768px)" srcset="{{asset('storage/Bzdykin/carousel/bmw-m6-768w.webp')}}">
                        <source media="(max-width: 1024px)" srcset="{{asset('storage/Bzdykin/carousel/bmw-m6-1024w.webp')}}">
                        <img src="{{asset('storage/Bzdykin/carousel/bmw-m6.webp')}}" alt="Раздел авто" />
                    </picture>
                </a>
                <div class="tooltip-black"><span>Авто</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'moto']) }}">
                    <picture>
                        <source media="(max-width: 375px)" srcset="{{asset('storage/Bzdykin/carousel/moto-375w.webp')}}">
                        <source media="(max-width: 768px)" srcset="{{asset('storage/Bzdykin/carousel/moto-768w.webp')}}">
                        <source media="(max-width: 1024px)" srcset="{{asset('storage/Bzdykin/carousel/moto-m6-1024w.webp')}}">
                        <img src="{{asset('storage/Bzdykin/carousel/moto.webp')}}" alt="Раздел мото" />
                    </picture>
                </a>
                <div class="tooltip-black"><span>Мото</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'law']) }}">
                    <picture>
                        <source media="(max-width: 375px)" srcset="{{asset('storage/Bzdykin/carousel/law-375w.webp')}}">
                        <source media="(max-width: 768px)" srcset="{{asset('storage/Bzdykin/carousel/law-768w.webp')}}">
                        <source media="(max-width: 1024px)" srcset="{{asset('storage/Bzdykin/carousel/law-1024w.webp')}}">
                        <img src="{{asset('storage/Bzdykin/carousel/law.webp')}}" alt="Раздел право"/>
                    </picture>
                </a>
                <div class="tooltip"><span>Право</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'helpful']) }}">
                    <picture>
                        <source media="(max-width: 375px)" srcset="{{asset('storage/Bzdykin/carousel/helpful-375w.webp')}}">
                        <source media="(max-width: 768px)" srcset="{{asset('storage/Bzdykin/carousel/helpful-768w.webp')}}">
                        <source media="(max-width: 1024px)" srcset="{{asset('storage/Bzdykin/carousel/helpful-1024w.webp')}}">
                        <img src="{{asset('storage/Bzdykin/carousel/helpful.webp')}}" alt="Раздел полезное"/>
                    </picture>
                </a>
                <div class="tooltip-black"><span>Полезное</span></div>
            </li>
        </ul>
    </div>
</div>