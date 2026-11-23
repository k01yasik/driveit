<nav class="breadcrumbs flex flex-v-center" aria-label="{{ __('Breadcrumbs') }}">
    <ul class="flex flex-v-center" role="list">
        @foreach ($items as $item)
            <x-breadcrumbs.item class="flex flex-v-center">
                @unless ($loop->first)
                    <span aria-hidden="true">/</span>
                @endunless

                @if (isset($item['route']))
                    <x-breadcrumbs.link :route="route($item['route'])">
                        {{ $item['label'] }}
                        @isset($item['badge'])
                            <strong class="unpublish-comments-counter">{{ $item['badge'] }}</strong>
                        @endisset
                    </x-breadcrumbs.link>
                @else
                    <strong aria-current="page">{{ $item['label'] }}</strong>
                @endif
            </x-breadcrumbs.item>
        @endforeach
    </ul>
</nav>
