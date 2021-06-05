@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.profile', ['username' => $user['username']]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
                    <span class="album-breadcrumbs-item">/</span>
                    <a href="{{ route('user.friends', ['username' => $user['username']]) }}" class="album-breadcrumbs-item">{{ __('Friends') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Friend requests') }}</div>
                </div>
                <div class="profile-block-content">
                    @if ($friendRequestCount > 0 )
                        <ul class="request-list">
                            @foreach($friendRequest as $friend)
                                <li class="users-element-request">
                                    <a href="{{ route('user.profile', ['username' => $friend['user']['username']]) }}" class="profile-link"><img src="{{ $friend['user']['profile']['avatar'] }}" class="avatar-image"></a>
                                    <a href="{{ route('user.profile', ['username' => $friend['user']['username']]) }}" class="profile-name">{{ $friend['user']['username'] }}</a>
                                    @if( $friend['confirmed'] )
                                        <div class="friend-request-button right" data-id="{{ $friend['user_id'] }}" data-username="{{ $user['username'] }}">
                                            <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="friend-request-button right" data-id="{{ $friend['user_id'] }}" data-username="{{ $user['username'] }}">
                                            <svg version="1.1" class="public-user-uncheck" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
                                                <g>
                                                    <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65
                                                    c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305
                                                    c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73
                                                    c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                            <li class="request-list-element">{{ __('All requests are processed') }}</li>
                        </ul>
                    @else
                        <h3>{{__('No results found')}}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection