@php
    $sections = [
        ['route' => 'admin.index', 'label' => __('Dashboard'), 'active' => ['admin.index']],
        ['route' => 'admin.posts', 'label' => __('Posts'), 'active' => ['admin.posts', 'admin.posts.*']],
        ['route' => 'admin.users', 'label' => __('Users'), 'active' => ['admin.users', 'admin.users.*', 'admin.user.*', 'admin.verified', 'admin.unverified', 'admin.banned']],
        ['route' => 'admin.comments', 'label' => __('Comments'), 'active' => ['admin.comments', 'admin.comments.*', 'admin.comment.*']],
        ['route' => 'admin.news.index', 'label' => __('News'), 'active' => ['admin.news.*', 'news.create']],
        ['route' => 'admin.seo', 'label' => __('Seo'), 'active' => ['admin.seo', 'seo.*']],
    ];
@endphp

<nav class="admin-navigation" aria-label="{{ __('Administration') }}">
    <ul>
        @foreach ($sections as $section)
            <li>
                <a href="{{ route($section['route']) }}"
                   @class(['admin-nav-link', 'is-active' => request()->routeIs(...$section['active'])])
                   @if (request()->routeIs($section['route'])) aria-current="page" @endif>
                    {{ $section['label'] }}
                </a>

                @if ($section['route'] === 'admin.users' && request()->routeIs(...$section['active']))
                    <ul class="admin-subnav">
                        @foreach (['admin.verified' => __('Verified'), 'admin.unverified' => __('Unverified'), 'admin.banned' => __('Banned')] as $route => $label)
                            <li>
                                <a href="{{ route($route) }}"
                                   @class(['admin-nav-link', 'is-active' => request()->routeIs($route)])
                                   @if (request()->routeIs($route)) aria-current="page" @endif>
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="admin-quick-links">
        <a href="{{ route('admin.posts.create') }}">{{ __('Create a post') }}</a>
        <a href="{{ route('seo.create') }}">{{ __('Create SEO entry') }}</a>
    </div>
</nav>
