@extends('layouts.main')

@section('content')
    <div class="content">
        <h2>{{ __('All public users list:') }}</h2>
        <ul>
            @foreach($profiles as $profile)
                <li class="users-element">
                    <a href="{{ route('user.profile', ['username' => $profile->user->username]) }}" class="profile-link"><img src="{{ $profile->avatar }}" class="avatar-image"></a>
                    <a href="{{ route('user.profile', ['username' => $profile->user->username]) }}" class="profile-name">{{ $profile->user->username }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection