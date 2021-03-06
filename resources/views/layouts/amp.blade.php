<!DOCTYPE html>
<html amp lang="ru">
<head>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <link rel="canonical" href="{{ route('posts.show', ['slug' => $post->slug]) }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="2b915c6348ef147d" />
    <x-seo.index :title="$seo['title']" :description="$seo['description']" :url="url()->current()" />
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic&display=swap">
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Article",
            "author": {
                "@type": "Person",
                "name": "{{ $post->user->username }}"
            },
            "name": "{{ $post->name }}",
            "description": "{{ $post->description }}",
            "image": "{{ $post->image_path }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ config('app.url') }}/posts/{{ $post->slug }}"
            },
            "datePublished": "{{ $post->getOriginal('date_published') }}",
            "dateModified": "{{ $post->getOriginal('date_published') }}",
            "headline": "{{ $post->name }}",
            "publisher": {
                "@type": "Organization",
                "name": "{{ config('app.name') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ config('app.url') }}/public/android-icon-192x192.png"
                }
            }
        }
    </script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        body {
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
            color: #3a3a3a;
        }
        .main-amp-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
        }
        .post-amp-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 2em 0;
        }
        .post-amp-wrapper h1 {
            font-weight: normal;
            margin: 0 0 1em;
        }
        .header-block {
            display: inline-block;
            width: 100%;
            line-height: 3em;
            margin-bottom: 1em;
        }
        .header-block-link {
            float: left;
            margin: .5em 1em .5em 0;
        }
        .header-block-img {
            float: left;
            border-radius: 50%;
        }
        .header-block-text-link {
            color: #3a3a3a;
            float: left;
            margin-right: 1em;
            text-decoration: none;
        }
        .right {
            float: right;
        }
        .amp-post-image {
            border-radius: 3px;
            margin-bottom: 2em;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>