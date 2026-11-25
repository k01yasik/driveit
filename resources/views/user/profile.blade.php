@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 l3 sm-margin-bottom-2 profile-block">
            @include('components.profile')
        </div>
        <div class="col s12 l9">
            <div class="profile-block">
                <div class="profile-block-content">
                    @php($name = trim(($user['profile']['first_name'] ?? '').' '.($user['profile']['last_name'] ?? '')))
                    <h1 class="profile-title">{{ $name ?: $user['username'] }}</h1>
                    @if (!empty($user['profile']['city']))
                        <p>{{ $user['profile']['city'] }}</p>
                    @endif
                    @if (!empty($user['profile']['about']))
                        <p>{!! nl2br(e($user['profile']['about'])) !!}</p>
                    @endif
                    @if ($currentUserProfile)
                        <a href="{{ route('user.settings', $user['username']) }}">{{ __('Edit profile') }}</a>
                    @endif
                    @if ($cars->isNotEmpty())
                        <h2 class="profile-title">{{ __('Garage') }}</h2>
                        <ul class="request-list">
                            @foreach ($cars as $car)
                                <li class="users-element">
                                    <span>{{ $car->make }} {{ $car->model }} @if ($car->year) ({{ $car->year }}) @endif</span>
                                    @if ($car->album)
                                        <a href="{{ route('user.albums.show', [$user['username'], $car->album->name]) }}">{{ $car->album->name }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
