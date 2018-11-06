@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="profile-block">
        <div class="album-breadcrumbs">
            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
            <span class="album-breadcrumbs-item">/</span>
            <a href="{{ route('user.friends', ['username' => $user->username]) }}" class="album-breadcrumbs-item">{{ __('Friends') }}</a>
            <span class="album-breadcrumbs-item">/</span>
            <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Search') }}</div>
        </div>
        <div class="profile-block-content">
            @if ($profiles->count() > 0 )
                <ul>
                    @foreach($profiles as $profile)
                        <li class="users-element friend-id-{{$profile->user->id}}">
                            <a href="{{ route('user.profile', ['username' => $profile->user->username]) }}" class="profile-link"><img src="{{ $profile->avatar }}" class="avatar-image"></a>
                            <a href="{{ route('user.profile', ['username' => $profile->user->username]) }}" class="profile-name">{{ $profile->user->username }}</a>
                            @if (in_array($profile->user->id, $confirmedFriends, true))
                                <div class="confirmed right">
                                    <svg version="1.1" class="checked-friend-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                        <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                                    </svg>
                                </div>
                            @elseif(in_array($profile->user->id, $requestedFriends, true))
                                <div class="waiting right" title="{{ __('Waiting for confirmation.') }}">
                                    <svg version="1.1" class="hourglass-friend-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                                        <g>
                                            <path d="M54,58h-3v-4h-5V43.778c0-2.7-1.342-5.208-3.589-6.706L31.803,30l10.608-7.072C44.658,21.43,46,18.922,46,16.222V6h5V2h3
                                            c0.552,0,1-0.447,1-1s-0.448-1-1-1h-3h-1H10H9H6C5.448,0,5,0.447,5,1s0.448,1,1,1h3v4h5v10.222c0,2.7,1.342,5.208,3.589,6.706
                                            L28.197,30l-10.608,7.072C15.342,38.57,14,41.078,14,43.778V54H9v4H6c-0.552,0-1,0.447-1,1s0.448,1,1,1h3h1h40h1h3
                                            c0.552,0,1-0.447,1-1S54.552,58,54,58z M18.698,21.264C17.009,20.137,16,18.252,16,16.222V6h28v10.222
                                            c0,2.03-1.009,3.915-2.698,5.042L30,28.798L18.698,21.264z M16,43.778c0-2.03,1.009-3.915,2.698-5.042L30,31.202l11.302,7.534
                                            C42.991,39.863,44,41.748,44,43.778V54H16V43.778z"></path>
                                        </g>
                                    </svg>
                                </div>
                            @else
                                <div class="request-friend right" title="{{__('Send request to add to friends')}}" data-friend="{{ $profile->user->id }}" data-username="{{ $user->username }}">
                                    <svg version="1.1" class="plus-friend-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 533.333 533.333" style="enable-background:new 0 0 533.333 533.333;"
                                    xml:space="preserve">
                                        <g>
                                            <path d="M516.667,200H333.333V16.667C333.333,7.462,325.871,0,316.667,0h-100C207.462,0,200,7.462,200,16.667V200H16.667
                                            C7.462,200,0,207.462,0,216.667v100c0,9.204,7.462,16.666,16.667,16.666H200v183.334c0,9.204,7.462,16.666,16.667,16.666h100
                                            c9.204,0,16.667-7.462,16.667-16.666V333.333h183.333c9.204,0,16.667-7.462,16.667-16.666v-100
                                            C533.333,207.462,525.871,200,516.667,200z"></path>
                                        </g>
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