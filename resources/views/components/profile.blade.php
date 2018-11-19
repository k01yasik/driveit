<div class="user-profile">
    <div class="avatar">
        <div class="avatar-inner">
            <img src="{{ $user->profile->avatar }}">
        </div>
    </div>
    <div class="user-profile-username">
        <a href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a>
    </div>
    <div class="channel hidden-element" data-id="{{ Auth::id() }}"></div>
    <ul>
        <li>
            <a href="{{ route('user.friends', ['username' => $user->username]) }}">{{ __('Friends') }}</a>
            @if ($currentUserProfile)
                @isset($friendRequestCount)
                    @if($friendRequestCount > 0)
                        <a href="{{ route('user.requests', ['username' => $user->username]) }}" class="friend-requests right">+{{ $friendRequestCount }}</a>
                    @else
                        <a href="{{ route('user.requests', ['username' => $user->username]) }}" class="friend-requests right" style="display:none;">0</a>
                    @endif
                @endisset
            @endif
        </li>
        @if($currentUserProfile)
            <li><a href="{{ route('users', ['username' => $user->username]) }}">{{ __('Find friends') }}</a></li>
            <li>
                <a href="{{ route('user.messages', ['username' => $user->username]) }}">{{ __('Messages') }}</a>
                <div class="messages-count right" style="display:none;">0</div>
            </li>
        @endif
        <li><a href="{{ route('user.albums.index', ['username' => $user->username]) }}">{{ __('Albums') }}</a></li>
        @if($currentUserProfile)
            <li><a href="{{ route('user.settings', ['username' => $user->username]) }}">{{ __('Settings') }}</a></li>
        @endif
    </ul>
</div>