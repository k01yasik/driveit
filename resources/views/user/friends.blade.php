@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="profile-block">
        <div class="album-breadcrumbs">
            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
            <span class="album-breadcrumbs-item">/</span>
            <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Friends') }}</div>
        </div>
        <div class="profile-block-content">
            @if ($friendList->count() > 0 )
                <ul class="request-list">
                    @foreach($friendList as $friend)
                        <li class="users-element">
                            <a href="{{ route('user.profile', ['username' => $friend->user->username]) }}" class="profile-link"><img src="{{ $friend->user->profile->avatar }}" class="avatar-image"></a>
                            <a href="{{ route('user.profile', ['username' => $friend->user->username]) }}" class="profile-name">{{ $friend->user->username }}</a>
                            @if( $friend->confirmed )
                                <div class="friend-button right">
                                    <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                        <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                                    </svg>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <h3>{{__('No results found')}}</h3>
            @endif
        </div>
    </div>
@endsection