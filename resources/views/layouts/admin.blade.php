<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('components.verification')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('seo.index')
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @include('components.google')
    @include('components.yandex')
    <script type="application/ld+json">
        {
            "@context" : "http://schema.org",
            "@type" : "Organization",
            "name" : "Driveitwith.me",
            "url" : "https://driveitwith.me",
            "sameAs" : [
                "https://vk.com/driveitwithme",
                "https://www.facebook.com/driveitwithme/",
                "https://www.facebook.com/groups/745210485639351/",
                "https://twitter.com/driveitwithme",
                "https://plus.google.com/u/0/communities/103637419906040787158",
                "https://plus.google.com/111603036897334855307"
            ],
            "logo" : "{{ config('app.url') }}/public/android-icon-192x192.png"
        }
    </script>
</head>
    <body>
    <header>
        @include('components.sitetop')
    </header>
    <div class="main-row">
        <div class="main-wrapper">
            @yield('content')
        </div>
    </div>
    <footer>
        @include('components.footer')
    </footer>
    @include('components.backbutton')
    @include('components.webfont')
    <script>
        let posts = {!! json_encode($posts->toArray(), JSON_HEX_TAG) !!};
        let commentsVerified = {!! $commentsVerified !!};
        let commentsNotVerified = {!! $commentsNotVerified !!};
        let datesQuery = {!! json_encode($datesQuery, JSON_HEX_TAG) !!};
        let usersQuery = {!! json_encode($usersQuery, JSON_HEX_TAG) !!};
        let sessionQuery = {!! json_encode($sessionQuery, JSON_HEX_TAG) !!};
        let hitsQuery = {!! json_encode($hitsQuery, JSON_HEX_TAG) !!};
        let countryQueryLabels = {!! json_encode($countryQueryLabels, JSON_HEX_TAG) !!};
        let countryQueryData = {!! json_encode($countryQueryData, JSON_HEX_TAG) !!};
        let cityQueryLabels = {!! json_encode($cityQueryLabels, JSON_HEX_TAG) !!};
        let cityQueryData = {!! json_encode($cityQueryData, JSON_HEX_TAG) !!}
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>