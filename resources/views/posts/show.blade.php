@extends('layouts.post')

@section('content')
    <div class="breadcrumbs flex flex-v-center">
        <ul class="flex flex-v-center">
            <li class="flex flex-v-center">
                <a href="{{ route('page.home') }}" class="breadcrumbs-home-link">
                    <svg version="1.1" class="home-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 27.02 27.02" xml:space="preserve">
                        <g>
                            <path d="M3.674,24.876c0,0-0.024,0.604,0.566,0.604c0.734,0,6.811-0.008,6.811-0.008l0.01-5.581
                            c0,0-0.096-0.92,0.797-0.92h2.826c1.056,0,0.991,0.92,0.991,0.92l-0.012,5.563c0,0,5.762,0,6.667,0
                            c0.749,0,0.715-0.752,0.715-0.752V14.413l-9.396-8.358l-9.975,8.358C3.674,14.413,3.674,24.876,3.674,24.876z"></path>
                            <path d="M0,13.635c0,0,0.847,1.561,2.694,0l11.038-9.338l10.349,9.28c2.138,1.542,2.939,0,2.939,0
                            L13.732,1.54L0,13.635z"></path>
                            <polygon points="23.83,4.275 21.168,4.275 21.179,7.503 23.83,9.752 	"></polygon>
                        </g>
                    </svg>
                </a>
            </li>
            <li class="flex flex-v-center"><span>/</span></li>
            <li class="flex flex-v-center"><a href="{{ route('posts.index') }}">{{ __('Posts') }}</a></li>
            <li class="flex flex-v-center"><span>/</span></li>
            @foreach($post['categories'] as $category)
                <li class="flex flex-v-center"><a href="{{ route('category.show', ['category' => $category['name']]) }}">{{mb_strtoupper(mb_substr($category['displayname'], 0, 1)) . mb_substr($category['displayname'], 1)}}</a></li>
                @if (!($loop->last))
                    <li class="flex flex-v-center"><span>/</span></li>
                @endif
            @endforeach
        </ul>
    </div>
    @auth
        <div class="article-readers rounded">
            <div class="article-readers-caption">{{ __('This article is also read by users') }}</div>
            <div class="article-readers-body">
            </div>
        </div>
    @endauth
    <article class="post full-post" @auth data-id="{{ $post['id'] }}"@endauth>
        <header>
            <div class="header-top v-h-3 flex flex-v-center">
                <a href="{{ route('user.profile', ['username' => $post['user']['username']]) }}" class="user-avatar-link">
                    <img src="{{ $post['user']['profile']['avatar'] }}" class="user-avatar" alt="{{ $post['user']['username'] }}" />
                </a>
                <a href="{{ route('user.profile', ['username' => $post['user']['username']]) }}" class="post-author margin-h-1 flex flex-v-center">{{ $post['user']['username'] }}</a>
                <div class="date-published margin-left-auto flex flex-v-center">{{ $post['date_published'] }}</div>
            </div>
            <div class="post-header">
                <div class="post-header-inner-show">
                    <h1 class="post-name">{{ $post['name'] }}</h1>
                    <div class="post-categories">
                        <svg version="1.1" class="tags-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 542.183 542.183" style="enable-background:new 0 0 542.183 542.183;"
                             xml:space="preserve">
                        <g>
                            <path d="M432.544,310.636c0-9.897-3.521-18.559-10.564-25.984L217.844,80.8c-7.232-7.238-16.939-13.374-29.121-18.416
                            c-12.181-5.043-23.319-7.565-33.407-7.565H36.545c-9.896,0-18.464,3.619-25.694,10.848C3.616,72.9,0,81.466,0,91.365v118.771
                            c0,10.088,2.519,21.219,7.564,33.404c5.046,12.185,11.187,21.792,18.417,28.837L230.12,476.799
                            c7.043,7.043,15.608,10.564,25.694,10.564c9.898,0,18.562-3.521,25.984-10.564l140.186-140.47
                            C429.023,329.284,432.544,320.725,432.544,310.636z M117.204,172.02c-7.139,7.138-15.752,10.709-25.841,10.709
                            c-10.085,0-18.698-3.571-25.837-10.709c-7.139-7.139-10.705-15.749-10.705-25.837c0-10.089,3.566-18.702,10.705-25.837
                            c7.139-7.139,15.752-10.71,25.837-10.71c10.089,0,18.702,3.571,25.841,10.71c7.135,7.135,10.707,15.749,10.707,25.837
                            C127.91,156.271,124.339,164.881,117.204,172.02z"></path>
                            <path d="M531.612,284.655L327.473,80.804c-7.23-7.238-16.939-13.374-29.122-18.417c-12.177-5.042-23.313-7.564-33.402-7.564
                            h-63.953c10.088,0,21.222,2.522,33.402,7.564c12.185,5.046,21.892,11.182,29.125,18.417l204.137,203.851
                            c7.046,7.423,10.571,16.084,10.571,25.981c0,10.089-3.525,18.647-10.571,25.693L333.469,470.519
                            c5.718,5.9,10.759,10.182,15.133,12.847c4.38,2.666,9.996,3.998,16.844,3.998c9.903,0,18.565-3.521,25.98-10.564l140.186-140.47
                            c7.046-7.046,10.571-15.604,10.571-25.693C542.179,300.739,538.658,292.078,531.612,284.655z"></path>
                        </g>
                    </svg>
                        <ul>
                            @foreach($post['categories'] as $category)
                                @if ($loop->last)
                                    <li><a href="{{ route('category.show', ['category' => $category['name']]) }}" class="category-link">{{$category['displayname']}}</a></li>
                                @else
                                    <li><a href="{{ route('category.show', ['category' => $category['name']]) }}" class="category-link">{{$category['displayname']}}</a>,</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="post-wrapper">
            <picture>
                <source media="(max-width: 375px)" srcset="{{ $post['image_path'] }}">
                <img src="{{ $post['image_path'] }}" alt="{{ $post['name'] }}" class="post-image">
            </picture>
        </div>
        <div class="post-buttons-wrapper">
            <div class="post-buttons-changed">
                <div class="eye-block">
                    <svg version="1.1" class="eye-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                            <path d="M508.177,245.995C503.607,240.897,393.682,121,256,121S8.394,240.897,3.823,245.995c-5.098,5.698-5.098,14.312,0,20.01
                            C8.394,271.103,118.32,391,256,391s247.606-119.897,252.177-124.995C513.274,260.307,513.274,251.693,508.177,245.995z M256,361
                            c-57.891,0-105-47.109-105-105s47.109-105,105-105s105,47.109,105,105S313.891,361,256,361z"></path>
                        </g>
                        <g>
                            <path d="M271,226c0-15.09,7.491-28.365,18.887-36.53C279.661,184.235,268.255,181,256,181c-41.353,0-75,33.647-75,75
                            c0,41.353,33.647,75,75,75c37.024,0,67.668-27.034,73.722-62.358C299.516,278.367,271,255.522,271,226z"></path>
                        </g>
                    </svg>
                    <p>{{ $post['views'] }}</p>
                </div>
                <div class="rating-block {{ Auth::check() ? 'rating-auth' : 'rating-guest' }}" title="{{ Auth::check() ? 'Проголосуй за статью' : 'Гости не могут голосовать' }}" data-id="{{ $post['id'] }}">
                    <svg version="1.1" class="star-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 46.354 46.354" style="enable-background:new 0 0 46.354 46.354;"
                    xml:space="preserve">
                        <g>
                            <path d="M21.57,2.049c0.303-0.612,0.927-1,1.609-1c0.682,0,1.307,0.388,1.609,1l5.771,11.695c0.261,0.529,0.767,0.896,1.352,0.981
                            L44.817,16.6c0.677,0.098,1.237,0.572,1.448,1.221c0.211,0.649,0.035,1.363-0.454,1.839l-9.338,9.104
                            c-0.423,0.412-0.616,1.006-0.517,1.588l2.204,12.855c0.114,0.674-0.161,1.354-0.715,1.756c-0.553,0.4-1.284,0.453-1.89,0.137
                            l-11.544-6.07c-0.522-0.275-1.147-0.275-1.67,0l-11.544,6.069c-0.604,0.317-1.337,0.265-1.89-0.136
                            c-0.553-0.401-0.829-1.082-0.714-1.756l2.204-12.855c0.1-0.582-0.094-1.176-0.517-1.588L0.542,19.66
                            c-0.489-0.477-0.665-1.19-0.454-1.839c0.211-0.649,0.772-1.123,1.449-1.221l12.908-1.875c0.584-0.085,1.09-0.452,1.351-0.982
                            L21.57,2.049z"></path>
                        </g>
                    </svg>
                    <p>{{ $post['rating_count'] }}</p>
                </div>
                <div class="comments-block">
                    <svg version="1.1" class="comments-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.626 511.626" style="enable-background:new 0 0 511.626 511.626;"
                    xml:space="preserve">
                        <g>
                            <path d="M301.927,327.605c30.926-13.038,55.34-30.785,73.23-53.248c17.888-22.458,26.833-46.915,26.833-73.372
                            c0-26.458-8.945-50.917-26.84-73.376c-17.888-22.459-42.298-40.208-73.228-53.249c-30.93-13.039-64.571-19.556-100.928-19.556
                            c-36.354,0-69.995,6.521-100.927,19.556c-30.929,13.04-55.34,30.789-73.229,53.249C8.947,150.072,0,174.527,0,200.986
                            c0,22.648,6.767,43.975,20.28,63.96c13.512,19.981,32.071,36.829,55.671,50.531c-1.902,4.572-3.853,8.754-5.852,12.566
                            c-2,3.806-4.377,7.467-7.139,10.991c-2.76,3.525-4.899,6.283-6.423,8.275c-1.523,1.998-3.997,4.812-7.425,8.422
                            c-3.427,3.617-5.617,5.996-6.567,7.135c0-0.191-0.381,0.24-1.143,1.287c-0.763,1.047-1.191,1.52-1.285,1.431
                            c-0.096-0.103-0.477,0.373-1.143,1.42c-0.666,1.048-1,1.571-1,1.571l-0.715,1.423c-0.282,0.575-0.476,1.137-0.57,1.712
                            c-0.096,0.567-0.144,1.19-0.144,1.854s0.094,1.28,0.288,1.854c0.381,2.471,1.475,4.466,3.283,5.996
                            c1.807,1.52,3.756,2.279,5.852,2.279h0.857c9.515-1.332,17.701-2.854,24.552-4.569c29.312-7.61,55.771-19.797,79.372-36.545
                            c17.129,3.046,33.879,4.568,50.247,4.568C237.353,347.16,270.998,340.645,301.927,327.605z"></path>
                            <path d="M491.354,338.166c13.518-19.889,20.272-41.247,20.272-64.09c0-23.414-7.146-45.316-21.416-65.68
                            c-14.277-20.362-33.694-37.305-58.245-50.819c4.374,14.274,6.563,28.739,6.563,43.398c0,25.503-6.368,49.676-19.129,72.519
                            c-12.752,22.836-31.025,43.01-54.816,60.524c-22.08,15.988-47.205,28.261-75.377,36.829
                            c-28.164,8.562-57.573,12.848-88.218,12.848c-5.708,0-14.084-0.377-25.122-1.137c38.256,25.119,83.177,37.685,134.756,37.685
                            c16.371,0,33.119-1.526,50.251-4.571c23.6,16.755,50.06,28.931,79.37,36.549c6.852,1.718,15.037,3.237,24.554,4.568
                            c2.283,0.191,4.381-0.476,6.283-1.999c1.903-1.522,3.142-3.61,3.71-6.272c-0.089-1.143,0-1.77,0.287-1.861
                            c0.281-0.09,0.233-0.712-0.144-1.852c-0.376-1.144-0.568-1.715-0.568-1.715l-0.712-1.424c-0.198-0.376-0.52-0.903-0.999-1.567
                            c-0.476-0.66-0.855-1.143-1.143-1.427c-0.28-0.284-0.705-0.763-1.28-1.424c-0.568-0.66-0.951-1.092-1.143-1.283
                            c-0.951-1.143-3.139-3.521-6.564-7.139c-3.429-3.613-5.899-6.42-7.422-8.418c-1.523-1.999-3.665-4.757-6.424-8.282
                            c-2.758-3.518-5.14-7.183-7.139-10.991c-1.998-3.806-3.949-7.995-5.852-12.56C459.289,374.859,477.843,358.062,491.354,338.166z"
                            ></path>
                        </g>
                    </svg>
                    <p>{{ $post['comments_count'] }}</p>
                </div>
            </div>
        </div>
        <div class="post-content margin-top-2">
            {!! $post['body'] !!}
        </div>
        <div class="social-likes margin-top-2">
            <div data-service="vkontakte" title="Share link on Vkontakte">Vkontakte</div>
            <div data-service="facebook" title="Share link on Facebook">Facebook</div>
            <div data-service="twitter" title="Share link on Twitter">Twitter</div>
        </div>
    </article>
    @if ($suggestPosts)
        @include('components.suggests')
    @endif
    @if ($sortedComments)
        <div class="caption-block">
            <div class="caption-block-text">{{ __('Comments') }}</div>
        </div>
        <div class="comments-wrapper">
            @foreach($sortedComments as $comment)
                @include('components.comment')
            @endforeach
        </div>
    @else
        <div class="caption-block">
            <div class="caption-block-text">{{ __('Comments') }}</div>
        </div>
        <div class="comments-wrapper">
            <div class="empty-comments">{{ __('No comments.') }}</div>
        </div>
    @endif
    @auth
        <div class="caption-block">
            <div class="caption-block-text">{{ __('Adding a comment') }}</div>
        </div>
        <div class="add-comment-wrapper" id="add-comment" data-post="{{ $post['id'] }}" data-level="0" data-parent="0" data-username="{{ $post['user']['username'] }}">
            @include('components.texteditor-mini', ['type' => 'comment'])
            <div class="button btn-post-height right add-comment-button">{{ __('Add a comment') }}</div>
        </div>
    @endauth
    @guest
        <div class="caption-block">
            <div class="caption-block-text">{{ __('Adding a comment') }}</div>
        </div>
        <div class="comments-wrapper">
            <div class="empty-comments">{{ __('Only registered users can post a new comment.') }}</div>
        </div>
    @endguest
@endsection
