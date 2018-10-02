@extends('layouts.empty')

@section('content')
    <div class="user-profile">
        <div class="avatar">
            <img src="{{ $user->profile->avatar }}">
        </div>
        <div class="user-profile-username">
            <p>{{ $user->username }}</p>
        </div>
        <ul>
            <li><a href="{{ route('user.friends', ['username' => $user->username]) }}">{{ __('Friends') }}</a></li>
            <li><a href="{{ route('user.messages', ['username' => $user->username]) }}">{{ __('Messages') }}</a> </li>
            <li><a href="{{ route('user.albums.index', ['username' => $user->username]) }}">{{ __('Albums') }}</a></li>
            <li><a href="{{ route('user.settings', ['username' => $user->username]) }}">{{ __('Settings') }}</a></li>

        </ul>
    </div>
    <div class="user-profile-content">

    </div>
@endsection