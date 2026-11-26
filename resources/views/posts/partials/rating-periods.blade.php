<nav class="rating-periods" aria-label="{{ __('Rating period') }}" @isset($ratingPeriod) data-rating-leaderboard @endisset>
    <a href="{{ route('posts.rated') }}" @unless (isset($ratingPeriod)) aria-current="page" @endunless>{{ __('All time') }}</a>
    <a href="{{ route('posts.rated.period', 'week') }}" @if (($ratingPeriod ?? null) === 'week') aria-current="page" @endif>{{ __('Last 7 days') }}</a>
    <a href="{{ route('posts.rated.period', 'month') }}" @if (($ratingPeriod ?? null) === 'month') aria-current="page" @endif>{{ __('Last 30 days') }}</a>
</nav>
