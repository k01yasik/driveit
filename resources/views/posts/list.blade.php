@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <h3 class="all-posts-item">{{ __('Posts') }}</h3>
        <span class="all-posts-item">/</span>
        <a href="{{ route('posts.index') }}" class="all-posts-item"><h3>{{ __('All posts') }}</h3></a>
    </div>
    @each('components.post', $posts, 'post')
    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
@endsection