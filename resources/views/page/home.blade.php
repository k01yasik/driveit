@extends('layouts.main')

@section('content')
    <div class="breadcrumbs flex flex-v-center">
        <ul class="flex flex-v-center">
            <li class="flex flex-v-center"><a href="{{ route('posts.index') }}" class="all-posts-item pill">{{ __('All posts') }}</a></li>
            <li class="flex flex-v-center"><a href="{{ route('posts.rated') }}" class="all-posts-item pill">{{ __('Best posts') }}</a></li>
            <li class="flex flex-v-center"><a href="{{ route('best.comments.month') }}" class="all-posts-item pill">{{ __('Best of the month by comments') }}</a></li>
        </ul>
    </div>
    @each('components.post', $posts, 'post')
@endsection