<div class="user-profile">
    <div class="avatar">
        <div class="avatar-inner">
            <img src="{{ $user->profile->avatar }}">
        </div>
    </div>
    <div class="user-profile-username">
        <p>{{ $user->username }}</p>
    </div>
    <ul>
        <li><a href="{{ route('user.friends', ['username' => $user->username]) }}">{{ __('Friends') }}</a></li>
        @if($currentUserProfile)
            <li><a href="{{ route('user.messages', ['username' => $user->username]) }}">{{ __('Messages') }}</a> </li>
        @endif
        <li><a href="{{ route('user.albums.index', ['username' => $user->username]) }}">{{ __('Albums') }}</a></li>
        @if($currentUserProfile)
            <li><a href="{{ route('user.settings', ['username' => $user->username]) }}">{{ __('Settings') }}</a></li>
        @endif
    </ul>
</div>