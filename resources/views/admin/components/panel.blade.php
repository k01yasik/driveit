<div class="left-panel">
    <div class="menu-header">
        {{ __('Menu') }}
    </div>
    <ul>
        <li><a href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a></li>
        <li><a href="{{ route('admin.posts') }}">{{ __('Posts') }}</a></li>
        <li><a href="{{ route('admin.users') }}">{{ __('Users') }}</a></li>
        <li><a href="{{ route('admin.comments') }}">{{ __('Comments') }}</a></li>
        <li><a href="{{ route('admin.seo') }}">{{ __('Seo') }}</a></li>
    </ul>
</div>