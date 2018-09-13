<div class="carousel-row">
    <div class="carousel-wrapper">
        <ul class="rslides">
            <li>
                <a href="{{ route('category.show', ['category' => 'auto']) }}">
                    <img src= "{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/bmw-m6.jpg" alt="Раздел авто" />
                </a>
                <div class="tooltip-black"><h2>Авто</h2></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'moto']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/moto.jpg" alt="Раздел мото" />
                </a>
                <div class="tooltip-black"><h2>Мото</h2></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'law']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/law.jpg" alt="Раздел право"/>
                </a>
                <div class="tooltip"><h2>Право</h2></div>
            </li>
            <li>
                <a href="{{ route('category.show', ['category' => 'helpful']) }}">
                    <img src="{{ config('filesystems.disks.public.url') }}/Bzdykin/carousel/helpful.jpg" alt="Раздел полезное"/>
                </a>
                <div class="tooltip-black"><h2>Полезное</h2></div>
            </li>
        </ul>
    </div>
</div>