@extends('layouts.amp')

@section('content')
    <div class="main-amp-wrapper">
        <div class="post-amp-wrapper">
            <h1>{{$post->name}}</h1>
            <div class="header-block">
                <a href="{{ route('user.profile', ['username' => $post->user->username]) }}" class="header-block-link">
                    <amp-img src="{{ $post->user->profile->avatar }}" width="32" height="32" alt="{{ $post->user->username }}" class="header-block-img"/>
                </a>
                <a href="{{ route('user.profile', ['username' => $post->user->username]) }}" class="header-block-text-link">{{ $post->user->username }}</a>
                <div class="right">{{ $post->date_published }}</div>
            </div>
            <amp-img src="{{ $post->image_path }}" class="amp-post-image" width="500" height="333" layout="responsive" alt="{{ $post->name }}"></amp-img>
            {!! $post->body !!}
        </div>
    </div>
@endsection