@php
    $viewer = Auth::id();
    $canVote = $viewer !== null && !empty($post['is_published']) && empty($post['archived_at']);
    $voted = $viewer !== null && collect($post['rating'] ?? [])->contains(
        fn ($vote) => (int) $vote['user_id'] === (int) $viewer && (int) $vote['rating'] === 1
    );
    $tag = $canVote ? 'button' : 'div';
@endphp
<{{ $tag }} class="rating-block post-vote {{ $canVote ? 'rating-auth' : 'rating-guest' }}"
    @if ($canVote)
        type="button" data-id="{{ $post['id'] }}" data-rating-url="{{ route('rating.post') }}"
        aria-pressed="{{ $voted ? 'true' : 'false' }}" aria-label="{{ __('Vote for post') }}"
    @endif
>
    <x-svg.star />
    <span data-rating-count aria-live="polite">{{ $post['rating_count'] }}</span>
    @if ($viewer !== null)
        <span data-rating-status @if (!$voted) hidden @endif>{{ __('You voted') }}</span>
    @endif
</{{ $tag }}>
