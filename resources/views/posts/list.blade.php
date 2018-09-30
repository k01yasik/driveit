@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <h3 class="all-posts-item">{{ __('Posts') }}</h3>
        <span class="all-posts-item">/</span>
        <a href="{{ route('posts.index') }}" class="all-posts-item"><h3>{{ __('All posts') }}</h3></a>
    </div>

    @each('components.post', $posts, 'post')

    @if ($data['hasPages'])
        <div class="pagination-wrapper">
            <ul class="pagination">
                @if ($data['currentPage'] == 1)
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['currentUrl'].'/page/'. $data['previousNumberPage'] }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $data['lastNumberPage']; $i++)
                    @if ($i == $data['currentPage'])
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                    @else
                        @if ($i == 1)
                            <li class="page-item"><a class="page-link" href="{{ $data['currentUrl'] }}">{{ $i }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $data['currentUrl'].'/page/'.$i }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endfor

                @if ($data['hasMorePages'])
                    <li class="page-item">
                        <a class="page-link" href="{{ $data['currentUrl'].'/page/'. $data['nextNumberPage'] }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection