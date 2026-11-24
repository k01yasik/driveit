<nav class="comment-filters" aria-label="{{ __('Comments') }}">
    <a href="{{ route('admin.comments') }}"
       @if (request()->routeIs('admin.comments', 'admin.comments.paginate')) aria-current="page" @endif>
        {{ __('All comments') }}
    </a>
    <a href="{{ route('admin.comments.unpublished') }}"
       @if (request()->routeIs('admin.comments.unpublished')) aria-current="page" @endif>
        {{ __('Unpublished comments') }}
        <span class="comment-filter-count">{{ $unpublish_comments_count }}</span>
    </a>
</nav>
