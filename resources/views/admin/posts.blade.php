@extends('layouts.empty')

@section('content')
    @include('admin.components.panel')
    <div class="right-panel">
        <div class="main-content-wrapper">
            <h2>{{ __('All posts') }}</h2>
            @foreach($posts as $post)
                <div class="post-block">
                    <div class="post-block-link">
                        <a href="{{ route('admin.posts.show', ['id' => $post->id]) }}">{{ $post->name }}</a>
                    </div>
                    @if ($post->is_published)
                        <div class="right publish" data-id="{{ $post->id }}">
                            <svg version="1.1" class="publish-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="right publish" data-id="{{ $post->id }}">
                            <svg version="1.1" class="unpublish-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65
                                    c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305
                                    c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73
                                    c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>
                                </g>
                            </g>
                        </svg>
                        </div>
                    @endif
                    <a href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" class="right edit-post">
                        <svg version="1.1" class="edit-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M397.736,78.378c6.824,0,12.358-5.533,12.358-12.358V27.027C410.094,12.125,397.977,0,383.08,0H121.641
                                c-3.277,0-6.42,1.303-8.739,3.62L10.527,105.995c-2.317,2.317-3.62,5.461-3.62,8.738v370.239C6.908,499.875,19.032,512,33.935,512
                                h349.144c14.897,0,27.014-12.125,27.014-27.027V296.289c0.001-6.824-5.532-12.358-12.357-12.358
                                c-6.824,0-12.358,5.533-12.358,12.358v188.684c0,1.274-1.031,2.311-2.297,2.311H33.936c-1.274,0-2.311-1.037-2.311-2.311v-357.88
                                h75.36c14.898,0,27.016-12.12,27.016-27.017V24.716H383.08c1.267,0,2.297,1.037,2.297,2.311V66.02
                                C385.377,72.845,390.911,78.378,397.736,78.378z M109.285,100.075c0,1.269-1.032,2.301-2.3,2.301H49.107l60.178-60.18V100.075z"></path>
                            </g>
                        </g>
                            <g>
                                <g>
                                    <path d="M492.865,100.396l-14.541-14.539c-16.304-16.304-42.832-16.302-59.138,0L303.763,201.28H103.559
                                c-6.825,0-12.358,5.533-12.358,12.358c0,6.825,5.533,12.358,12.358,12.358h175.488l-74.379,74.379H103.559
                                c-6.825,0-12.358,5.533-12.358,12.358s5.533,12.358,12.358,12.358h76.392l-0.199,0.199c-1.508,1.508-2.598,3.379-3.169,5.433
                                l-19.088,68.747h-53.936c-6.825,0-12.358,5.533-12.358,12.358s5.533,12.358,12.358,12.358h63.332c0.001,0,2.709-0.306,3.107-0.41
                                c0.065-0.017,77.997-21.642,77.997-21.642c2.054-0.57,3.926-1.662,5.433-3.169l239.438-239.435
                                C509.168,143.228,509.168,116.7,492.865,100.396z M184.644,394.073l10.087-36.326l26.24,26.24L184.644,394.073z M244.69,372.752
                                l-38.721-38.721l197.648-197.648l38.722,38.721L244.69,372.752z M475.387,142.054l-15.571,15.571l-38.722-38.722l15.571-15.571
                                c6.669-6.668,17.517-6.667,24.181,0l14.541,14.541C482.054,124.54,482.054,135.388,475.387,142.054z"></path>
                                </g>
                            </g>
                    </svg>
                    </a>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        </div>
        @if ($posts->hasPages())
            <div class="pagination-wrapper">
                <ul class="pagination">
                    @if ($posts->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ config('app.url').'/admin/posts/page/'. $previousNumberPage }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    @for ($i = 1; $i <= $lastNumberPage; $i++)
                        @if ($i == $posts->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                        @else
                            @if ($i == 1)
                                <li class="page-item"><a class="page-link" href="{{ config('app.url').'/admin/posts' }}">{{ $i }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ config('app.url').'/admin/posts/page/'.$i }}">{{ $i }}</a></li>
                            @endif
                        @endif
                    @endfor

                    @if ($posts->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ config('app.url').'/admin/posts/page/'. $nextNumberPage }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
@endsection