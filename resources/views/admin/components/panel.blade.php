<div class="left-panel">
    <div class="avatar">
        <div class="avatar-inner">
            <img src="{{ $user->profile->avatar }}">
        </div>
    </div>
    <div class="user-profile-username">
        <a href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a>
    </div>
    <ul>
        <li><a href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a></li>
        <li><a href="{{ route('admin.posts') }}">{{ __('Posts') }}</a></li>
        <li><a href="{{ route('admin.users') }}">{{ __('Users') }}</a></li>
        <li><a href="{{ route('admin.comments') }}">{{ __('Comments') }}</a></li>
        <li><a href="{{ route('admin.seo') }}">{{ __('Seo') }}</a></li>
    </ul>
</div>