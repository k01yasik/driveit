@extends('layouts.main')

@section('content')
    @each('components.post', $posts, 'post')
    <div class="pagination-wrapper">
        @if ($posts->hasPages())
            <ul class="pagination" role="navigation">
                @if ($posts->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ config('app.url').'/posts/pages/'. $previousNumberPage }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $lastNumberPage; $i++)
                    @if ($i == $posts->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                    @else
                        @if ($i == 1)
                            <li class="page-item"><a class="page-link" href="{{ config('app.url').'/posts' }}">{{ $i }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ config('app.url').'/posts/pages/'.$i }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endfor

                @if ($posts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ config('app.url').'/posts/pages/'. $nextNumberPage }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
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