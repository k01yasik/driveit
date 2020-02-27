@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="right-panel">
                <div class="breadcrumbs flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">
                            <a href="{{ route('admin.index') }}" class="breadcrumbs-home-link">
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
                        <li class="flex flex-v-center">{{ __('Comments') }}</li>
                        @if ($unpublish_comments_count > 0)
                            <li class="flex flex-v-center"><span>/</span></li>
                            <li class="flex flex-v-center"><a href="{{ route('admin.comments.unpublished') }}">{{ __('Unpublished comments') }}</a></li>
                            <li class="unpublish-comments-counter flex flex-v-center flex-h-center-all">{{ $unpublish_comments_count }}</li>
                        @endif
                    </ul>
                </div>
                @if ($comments->count() > 0)
                    <div class="comments-wrapper">
                        @foreach($comments as $comment)
                            <div class="comment-item">
                                <div class="header flex flex-v-center flex-justify-space">
                                    <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="user-avatar-link header-item">
                                        <img src="{{ $comment->user->profile->avatar }}" class="user-avatar" alt="{{ $comment->user->username }}" />
                                    </a>
                                    <a href="{{ route('user.profile', ['username' => $comment->user->username]) }}" class="post-author header-item">{{ $comment->user->username }}</a>
                                    <div class="comment-publish-button margin-left-auto" data-id="{{ $comment->id }}">
                                        @if ($comment->is_verified)
                                            <svg version="1.1" class="comment-publish-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                                            </svg>
                                        @else
                                            <svg version="1.1" class="comment-unpublish-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
                                                <g>
                                                    <g>
                                                    <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65
                                                    c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305
                                                    c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73
                                                    c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="comment-created">{{ $comment->created_at }}</div>
                                </div>
                                <div class="body">
                                    <p>{{ $comment->message }}</p>
                                </div>
                                <div class="comment-footer">
                                    <p>{{ __('Comment on the article') }} <a href="{{ route('posts.show', ['slug' => $comment->post->slug]) }}">{{ $comment->post->name }}</a></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @include('components.pagination')
            </div>
        </div>
    </div>
@endsection