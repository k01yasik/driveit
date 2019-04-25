<div class="leaderboard">
    <div class="leaderboard-text">{{ __('Advertisement') }}</div>
    @isset ($adverts)
        @foreach($adverts as $advert)
            <div class="advertisement">
                {!! $advert->ad !!}
            </div>
        @endforeach
    @endisset
</div>