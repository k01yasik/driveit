@extends('layouts.profile')

@section('content')
    @php
        $username = $user['username'];
        $details = $user['profile'] ?? [];
        $name = trim(($details['first_name'] ?? '').' '.($details['last_name'] ?? '')) ?: $username;
        $sections = ['journal' => __('Journal'), 'garage' => __('Garage'), 'about' => __('About me')];
    @endphp

    <div class="member-page">
        <p class="member-breadcrumb"><a href="{{ route('page.home') }}">DriveIt</a> <span aria-hidden="true">/</span> {{ __('Profile') }}</p>

        <section class="member-card member-header" aria-labelledby="member-name">
            <div class="member-cover"></div>
            <div class="member-identity">
                <div class="member-actions">
                    @include('user.partials.profile-avatar')

                    @if ($currentUserProfile)
                        <a class="member-edit" href="{{ route('user.settings', $username) }}">{{ __('Edit profile') }}</a>
                    @endif
                </div>
                <h1 id="member-name">{{ $name }}</h1>
                <p class="member-meta">{{ '@'.$username }}@if (!empty($details['city'])) · {{ $details['city'] }}@endif</p>
                @if (!empty($details['about']))
                    <p class="member-bio">{{ \Illuminate\Support\Str::limit($details['about'], 240) }}</p>
                @endif
                <div class="member-stats">
                    @if ($posts)
                        <span>{{ __('Posts') }} <strong>{{ $posts->total() }}</strong></span>
                    @endif
                    <span>{{ __('Garage') }} <strong>{{ $cars->count() }}</strong></span>
                </div>
            </div>
            <nav class="member-tabs" aria-label="{{ __('Profile') }}">
                @foreach ($sections as $key => $label)
                    <a href="{{ route('user.profile', $key === 'journal' ? ['username' => $username] : ['username' => $username, 'section' => $key]) }}#profile-content"
                       @if ($section === $key) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>
        </section>

        <div class="member-grid">
            <section id="profile-content" class="member-stack" aria-labelledby="member-section">
                <h2 id="member-section">{{ $sections[$section] }}</h2>
                @if ($section === 'journal')
                    @forelse ($posts as $post)
                        <x-post :post="$post" />
                    @empty
                        <p class="member-card member-panel">{{ __('No published posts yet.') }}</p>
                    @endforelse
                    {{ $posts->links('pagination::simple-bootstrap-4') }}
                @elseif ($section === 'garage')
                    @forelse ($cars as $car)
                        <article class="member-card member-panel">
                            <h3>{{ $car->make }} {{ $car->model }}</h3>
                            @if ($car->year)
                                <p class="member-meta">{{ $car->year }}</p>
                            @endif
                            @if ($car->album)
                                <a href="{{ route('user.albums.show', [$username, $car->album->name]) }}">{{ $car->album->name }}</a>
                            @endif
                        </article>
                    @empty
                        <p class="member-card member-panel">{{ __('No cars in the garage yet.') }}</p>
                    @endforelse
                @else
                    <p class="member-card member-panel member-bio">{{ $details['about'] ?? __('The user has not added a bio yet.') }}</p>
                @endif
            </section>

            <aside class="member-stack" aria-label="{{ __('Profile') }}">
                @if ($section !== 'garage' && ($firstCar = $cars->first()))
                    <section class="member-card member-panel">
                        <h2>{{ __('Garage') }}</h2>
                        <a href="{{ route('user.profile', ['username' => $username, 'section' => 'garage']) }}#profile-content">{{ $firstCar->make }} {{ $firstCar->model }}</a>
                        @if ($firstCar->year)
                            <p class="member-meta">{{ $firstCar->year }}</p>
                        @endif
                        @if ($firstCar->album)
                            <p><a href="{{ route('user.albums.show', [$username, $firstCar->album->name]) }}">{{ $firstCar->album->name }}</a></p>
                        @endif
                    </section>
                @endif
                <nav class="member-card member-panel member-menu" aria-label="{{ __('Profile links') }}">
                    <h2>{{ __('Profile links') }}</h2>
                    @include('user.partials.profile-menu')
                </nav>
            </aside>
        </div>
        <div class="channel hidden-element" data-id="{{ Auth::id() }}"></div>
    </div>
@endsection
