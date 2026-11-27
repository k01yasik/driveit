<div class="user-profile">
    <div class="user-profile-left-panel">
        @include('user.partials.profile-avatar')
        <div class="user-profile-username">
            <a href="{{ route('user.profile', ['username' => $user['username']]) }}">{{ $user['username'] }}</a>
        </div>
        <div class="channel hidden-element" data-id="{{ Auth::id() }}"></div>
    </div>
    <div class="user-profile-right-panel">
        @include('user.partials.profile-menu')
    </div>
</div>
