<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('admin-title') · {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon-32x32.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-page">
    <a class="admin-skip-link" href="#admin-content">{{ __('Skip to content') }}</a>
    <header class="admin-topbar">
        <div class="admin-topbar-inner">
            <a class="admin-brand" href="{{ route('admin.index') }}">web-rookie<span>.ru</span></a>
            <div class="admin-topbar-links">
                <a href="{{ route('page.home') }}">{{ __('View site') }}</a>
                <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}">
                    {{ auth()->user()->username }}
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">{{ __('Log out') }}</button>
                </form>
            </div>
        </div>
    </header>

    <div class="admin-shell">
        <aside class="admin-sidebar">
            @include('admin.components.panel')
        </aside>
        <main class="admin-content" id="admin-content" tabindex="-1">
            <h1 class="admin-page-title">@yield('admin-title')</h1>
            @yield('content')
        </main>
    </div>

    @stack('admin-scripts')
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
