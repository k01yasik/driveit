@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="album-breadcrumbs rounded">
                    <a href="{{ route('user.profile', ['username' => $user['username']]) }}" class="album-breadcrumbs-item">{{ __('Profile') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Friends') }}</div>
                </div>
                <div class="profile-block-content rounded">
                    @if (count($friendList) > 0 )
                        <ul class="request-list">
                            @foreach($friendList as $friend)
                                <li class="users-element">
                                    <a href="{{ route('user.profile', ['username' => $friend['user']['username']]) }}" class="profile-link"><img src="{{ $friend['user']['profile']['avatar'] }}" class="avatar-image"></a>
                                    <a href="{{ route('user.profile', ['username' => $friend['user']['username']]) }}" class="profile-name">{{ $friend['user']['username'] }}</a>
                                    @if ($currentUserProfile)
                                        <form method="POST" action="{{ route('user.friends.destroy', [$user['username'], $friend['user_id']]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-flat" type="submit">{{ __('Remove friend') }}</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h3>{{__('No results found')}}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection