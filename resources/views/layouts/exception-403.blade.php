<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="2b915c6348ef147d" />
    <x-seo.index :title="__('An error has occurred')" :description="__('An error has occurred')" :url="url()->current()" />
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preload" href="{{asset('css/app.css')}}" as="style">
    <link rel="preload" href="{{ asset('js/manifest.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/vendor.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/app.ts') }}" as="script">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KRG3CV2');
    </script>
    <x-schema />
</head>
    <body class="header full-height">
        <x-noscript.googletag-noscript/>
        <x-noscript.yandex-noscript/>
        <header>
            <x-sitetop />
            <div class="hero">
                <div class="hero__wrapper">
                    <div class="hero__logo">
                        <div class="hero__img"></div>
                    </div>
                    <div class="hero__content exception">
                        <h1>{{ __('Error 403') }}</h1>
                        <p>{{ __($exception->getMessage()) }}</p>
                    </div>
                </div>
            </div>
            <x-navigation />
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
        </footer>
        <script src="{{ asset('js/manifest.js') }}"></script>
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="{{ asset('js/app.ts') }}"></script>
    </body>
</html>
