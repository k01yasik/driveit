<div class="comment-item level-{{ $comment->level }}" data-level="{{ $comment->level }}">
    <div class="header">
        <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="user-avatar-link header-item">
            <img src="{{ $comment->user->profile->avatar }}" class="user-avatar" alt="{{ $comment->user->username }}" />
        </a>
        <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="post-author header-item">{{ $comment->user->username }}</a>
        <div class="right">{{ $comment->created_at }}</div>
        @if ($comment->level < 3 && $comment->is_verified == 1 && $authenticated)
            <div class="right reply-button" data-level="{{ $comment->level }}" data-parent="{{ $comment->id }}">{{ __('Reply') }}</div>
        @endif
    </div>
    <div class="body">
        @if ( $comment->is_verified == 1)
            {!! $comment->message !!}
        @else
            <p>{{ __('Comment was sent for moderation.') }}</p>
        @endif
    </div>
</div>