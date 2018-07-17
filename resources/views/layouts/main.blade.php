<!DOCTYPE html>
<html lang="ru">
    <head>
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
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="aLlUmbWjE1uTvbSk_PSrOhYnCMqVjo8DCUvDBuX8n_I" />
        <meta name='yandex-verification' content='7d1b25881aa614ae' />
        <meta name='wmail-verification' content='0bb02aeb0edea4483300fbf570934ffd' />
        <meta name="msvalidate.01" content="5C7980ED46474154F14D366202946FE3" />
        <meta name="790ac42607dbab4325ac5d1f68751ae2" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
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
                ]
            }
        </script>
    </head>
    <body>
        <header>
            @include('components.sitetop')
            @include('components.carousel')
            @include('components.navigation')
        </header>
        <div class="main-row">
            <div class="main-wrapper">
                <main>
                   @yield('content')
                </main>
                <aside>
                    @include('components.ads')
                    @include('components.comments')
                </aside>
            </div>
        </div>
        <footer>
            @include('components.footer')
        </footer>
        @include('components.backbutton')
    </body>
</html>