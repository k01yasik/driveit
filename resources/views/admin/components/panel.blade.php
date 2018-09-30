<div class="left-panel">
    <div class="menu-header">
        {{ __('Menu') }}
    </div>
    <ul>
        <li><a href="{{ route('admin.posts') }}">{{ __('Posts') }}</a>
            @if($posts_count > 0)<span class="right">{{ $posts_count }}</span>@endif
        </li>
        <li><a href="{{ route('admin.users') }}">{{ __('Users') }}</a><span class="right">{{ $users_count }}</span></li>
        <li><a href="{{ route('admin.comments') }}">{{ __('Comments') }}</a>
            @if($comments_count > 0)<span class="right">{{ $comments_count }}</span>@endif
        </li>
        <li><a href="{{ route('admin.seo') }}">{{ __('Seo') }}</a>
            @if($seo_count > 0)<span class="right">{{ $seo_count }}</span>@endif
        </li>
    </ul>
</div>