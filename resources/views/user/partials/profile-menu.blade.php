<ul>
    <li>
        <a href="{{ route('user.friends', ['username' => $user['username']]) }}">{{ __('Friends') }}</a>
        @if ($currentUserProfile)
            <a href="{{ route('user.requests', $user['username']) }}" class="right">
                {{ __('Friend requests') }} <span class="friend-requests" @if (!$friendRequestCount) hidden @endif>+{{ $friendRequestCount }}</span>
            </a>
        @endif
    </li>
    @if($currentUserProfile)
        <li><a href="{{ route('users', ['username' => $user['username']]) }}">{{ __('Find friends') }}</a></li>
        <li><a href="{{ route('draft.index', ['username' => $user['username']]) }}">{{ __('Drafts') }}</a></li>
        <li>
            <a href="{{ route('user.messages', ['username' => $user['username']]) }}">{{ __('Messages') }}</a>
            <div class="messages-count right" @if (!$unreadMessageCount) hidden @endif>{{ $unreadMessageCount }}</div>
        </li>
    @endif
    <li><a href="{{ route('user.albums.index', ['username' => $user['username']]) }}">{{ __('Albums') }}</a></li>
    @if($currentUserProfile)
        <li>
            <a href="{{ route('user.maintenance.index', $user['username']) }}">{{ __('Maintenance') }}</a>
            @if ($dueMaintenanceCount > 0)
                <span class="right" aria-label="{{ __('Maintenance due: :count', ['count' => $dueMaintenanceCount]) }}">{{ $dueMaintenanceCount }}</span>
            @endif
        </li>
        <li><a href="{{ route('user.settings', ['username' => $user['username']]) }}">{{ __('Settings') }}</a></li>
    @endif
</ul>
