@php
    $id = data_get($comment, 'id');
    $username = data_get($comment, 'user.username');
    $avatar = data_get($comment, 'user.profile.avatar');
    $date = data_get($comment, 'created_at');
@endphp
<article class="comment-card" data-comment-id="{{ $id }}">
    <header class="comment-header">
        <a href="{{ route('user.profile', $username) }}" class="comment-user">
            @if ($avatar)
                <span class="user-avatar">
                    <img src="{{ $avatar }}" alt="" loading="lazy" width="40" height="40">
                </span>
            @endif
            <strong class="user-name">{{ $username }}</strong>
        </a>

        <div class="comment-actions">
            @if ($comment instanceof \App\Comment)
                <time class="comment-date" datetime="{{ \Illuminate\Support\Carbon::parse($comment->getRawOriginal('created_at'))->toIso8601String() }}">
                    {{ $date }}
                </time>
            @else
                <span class="comment-date">{{ $date }}</span>
            @endif
            <button class="comment-toggle-publish comment-publish-button" type="button" data-id="{{ $id }}"
                    aria-label="{{ __('Change publication status') }}">
                @if (data_get($comment, 'is_verified'))
                    <svg class="comment-publish-svg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/>
                    </svg>
                @else
                    <svg class="comment-unpublish-svg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 5h14v14H5zm2 2v10h10V7z" fill-rule="evenodd"/>
                    </svg>
                @endif
            </button>
        </div>
    </header>

    <div class="comment-body"><p>{{ data_get($comment, 'message') }}</p></div>

    @if (data_get($comment, 'post.slug'))
        <footer class="comment-footer">
            <p>{{ __('Comment on the article') }}
                <a href="{{ route('posts.show', data_get($comment, 'post.slug')) }}">{{ data_get($comment, 'post.name') }}</a>
            </p>
        </footer>
    @endif
</article>
