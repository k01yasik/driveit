<div class="comment-item level-{{ $comment->level }}">
    <div class="header">
        <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="user-avatar-link header-item">
            <img src="{{ $comment->user->profile->avatar }}" class="user-avatar" alt="{{ $comment->user->username }}" />
        </a>
        <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="post-author header-item">{{ $comment->user->username }}</a>
        <div class="right">{{ $comment->created_at }}</div>
    </div>
    <div class="body">
        <p>{{ $comment->message }}</p>
    </div>
</div>