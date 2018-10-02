@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <div class="all-posts-item">{{ __('Posts') }}</div>
        <span class="all-posts-item">/</span>
        <a href="{{ route('posts.index') }}" class="all-posts-item"><div>{{ __('All posts') }}</div></a>
    </div>
    @each('components.post', $posts, 'post')
@endsection