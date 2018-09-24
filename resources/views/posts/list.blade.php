@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <h3 class="all-posts-item">{{ __('Posts') }}</h3>
        <span class="all-posts-item">/</span>
        <a href="{{ route('posts.index') }}" class="all-posts-item"><h3>{{ __('All posts') }}</h3></a>
    </div>
    @each('components.post', $posts, 'post')
    <div class="pagination-wrapper">
        @if ($hasPages)
            <ul class="pagination">
                @if ($currentPage == 1)
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $currentUrl.'/page/'. $previousNumberPage }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $lastNumberPage; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                    @else
                        @if ($i == 1)
                            <li class="page-item"><a class="page-link" href="{{ $currentUrl }}">{{ $i }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $currentUrl.'/page/'.$i }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endfor

                @if ($hasMorePages)
                    <li class="page-item">
                        <a class="page-link" href="{{ $currentUrl.'/page/'. $nextNumberPage }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        @endif
    </div>
@endsection