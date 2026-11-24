<nav class="comment-filters" aria-label="{{ __('Comments') }}">
    <a href="{{ route('admin.comments') }}"
       @if (request()->routeIs('admin.comments', 'admin.comments.paginate')) aria-current="page" @endif>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.5H5l1.5-3A8.4 8.4 0 1 1 21 11.5ZM9 11h7m-7 4h4"/>
        </svg>
        {{ __('All comments') }}
    </a>
    <a href="{{ route('admin.comments.unpublished') }}"
       @if (request()->routeIs('admin.comments.unpublished')) aria-current="page" @endif>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <path d="M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
        {{ __('Unpublished comments') }}
        <span class="comment-filter-count">{{ $unpublish_comments_count }}</span>
    </a>
</nav>
