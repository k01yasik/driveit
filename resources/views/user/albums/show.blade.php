@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="album-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
                    <span class="album-breadcrumbs-item">/</span>
                    <a href="{{ route('user.albums.index', ['username' => $user->username]) }}" class="album-breadcrumbs-item">{{ __('Albums') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ $album->name }}</div>
                </div>
                @if ($currentUserProfile)
                    <div class="add-image">
                        <div class="add-image-button">
                            <svg version="1.1" class="add-image-plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 533.333 533.333" style="enable-background:new 0 0 533.333 533.333;"
                            xml:space="preserve">
                                <g>
                                    <path d="M516.667,200H333.333V16.667C333.333,7.462,325.871,0,316.667,0h-100C207.462,0,200,7.462,200,16.667V200H16.667
                                    C7.462,200,0,207.462,0,216.667v100c0,9.204,7.462,16.666,16.667,16.666H200v183.334c0,9.204,7.462,16.666,16.667,16.666h100
                                    c9.204,0,16.667-7.462,16.667-16.666V333.333h183.333c9.204,0,16.667-7.462,16.667-16.666v-100
                                    C533.333,207.462,525.871,200,516.667,200z"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="image-progress-wrapper">
                            <progress max="100" value="0" class="image-progress"></progress>
                        </div>
                        <div class="add-image-footer">{{ __('Add an image') }}</div>
                        <form enctype="multipart/form-data" id="upload_image_to_album">
                            <input type="file" id="upload_image_to_album_input" accept="image/jpeg,image/png" name="upload_image_to_album_input" multiple data-name="{{ $album->name }}" data-username="{{ $user->username }}">
                        </form>
                    </div>
                @endif
                @if ($images->count() > 0)
                    <div class="image-wrapper">
                    @foreach($images  as $image)
                        <div class="image-block">
                            @if ($image->url_thumbnail)
                                @if ($currentUserProfile)
                                    <div class="image-block-top">
                                        <div class="image-block-top-button" data-id="{{ $image->id }}" data-path="{{ $image->path }}" data-thumbnail="{{ $image->path_thumbnail }}" data-username="{{ $user->username }}" data-album="{{ $album->id }}">
                                            <svg version="1.1" class="image-block-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"
                                            xml:space="preserve">
                                                <g>
                                                    <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
                                                    c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
                                                    c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
                                                    c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
                                                    s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <img src="{{$image->url_thumbnail}}" data-url="{{$image->url}}" />
                                <div class="image-block-footer">
                                    <div class="image-block-footer-counter">{{ $image->favorites->count() }}</div>
                                    <div class="image-block-footer-wrapper">
                                        <div class="image-block-footer-button" data-id="{{ $image->id }}" data-username="{{ $user->username }}">
                                            <svg version="1.1" class="heart-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                                <g>
                                                    <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55
                                                    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if($currentUserProfile)
                                    <div class="image-block-top">
                                        <div class="image-block-top-button" data-id="{{ $image->id }}" data-path="{{ $image->path }}" data-thumbnail="{{ $image->path_thumbnail }}" data-username="{{ $user->username }}"  data-album="{{ $album->id }}">
                                            <svg version="1.1" class="image-block-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"
                                                 xml:space="preserve">
                                                <g>
                                                    <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
                                                    c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
                                                    c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
                                                    c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
                                                    s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <img src="{{ $image->url }}" />
                                <div class="image-block-footer">
                                    <div class="image-block-footer-counter">{{ $image->favorites->count() }}</div>
                                    <div class="image-block-footer-wrapper">
                                        <div class="image-block-footer-button" data-id="{{ $image->id }}" data-username="{{ $user->username }}">
                                            <svg version="1.1" class="heart-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                                <g>
                                                    <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55
                                                    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="no-images">{{ __('The album is empty') }}</div>
                    <div class="image-wrapper" style="display:none;"></div>
                @endif
            </div>
        </div>
    </div>
@endsection