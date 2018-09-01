@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <h2 class="all-posts-item">{{ __('Posts') }}</h2>
        <span class="all-posts-item">/</span>
        <a href="{{ route('posts.index') }}" class="all-posts-item"><h2>{{ __('All posts') }}</h2></a>
    </div>
    @each('components.post', $posts, 'post')
@endsection