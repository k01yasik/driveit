@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="profile-block">
        <div class="album-breadcrumbs">
            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
            <span class="album-breadcrumbs-item">/</span>
            <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Messages') }}</div>
        </div>
        <div class="profile-block-content">
            @if ($friendList->count() > 0 )
                <ul class="request-list">
                    @foreach($friendList as $friend)
                        <li class="users-element">
                            <a href="{{ route('user.friend.messages', ['username' => $user->username, 'friend' => $friend->user->username]) }}" class="users-element-link">
                                <div class="profile-link"><img src="{{ $friend->user->profile->avatar }}" class="avatar-image"></div>
                                <div class="profile-name">{{ $friend->user->username }}</div>
                                <div class="friend-button right">
                                    <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 444.815 444.815" style="enable-background:new 0 0 444.815 444.815;"
                                    xml:space="preserve">
                                        <g>
                                            <path d="M421.976,196.712L236.111,10.848C228.884,3.615,220.219,0,210.131,0c-9.9,0-18.464,3.615-25.697,10.848L163.023,32.26
                                            c-7.234,6.853-10.85,15.418-10.85,25.697c0,10.277,3.616,18.842,10.85,25.697l83.653,83.937H45.677
                                            c-9.895,0-17.937,3.568-24.123,10.707s-9.279,15.752-9.279,25.837v36.546c0,10.088,3.094,18.698,9.279,25.837
                                            s14.228,10.704,24.123,10.704h200.995L163.02,360.88c-7.234,7.228-10.85,15.89-10.85,25.981c0,10.089,3.616,18.75,10.85,25.978
                                            l21.411,21.412c7.426,7.043,15.99,10.564,25.697,10.564c9.899,0,18.562-3.521,25.981-10.564l185.864-185.864
                                            c7.043-7.043,10.567-15.701,10.567-25.981C432.54,211.939,429.016,203.37,421.976,196.712z"></path>
                                        </g>
                                    </svg>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <h3>{{__('No results found')}}</h3>
            @endif
        </div>
    </div>
@endsection