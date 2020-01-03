<div class="carousel-row">
    <div class="carousel-wrapper">
        <ul class="rslides">
            <li>
                <a href="{{ route('category.show', ['category' => 'auto']) }}">
                    <img src= "{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/bmw-m6.webp" alt="Раздел авто" />
                </a>
                <div class="tooltip-black"><span>Авто</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'moto']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/moto.webp" alt="Раздел мото" />
                </a>
                <div class="tooltip-black"><span>Мото</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'law']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/law.webp" alt="Раздел право"/>
                </a>
                <div class="tooltip"><span>Право</span></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'helpful']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/helpful.webp" alt="Раздел полезное"/>
                </a>
                <div class="tooltip-black"><span>Полезное</span></div>
            </li>
        </ul>
    </div>
</div>