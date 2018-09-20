@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <h3 class="all-posts-item">{{ __('Searching results') }}</h3>
    </div>
    @each('components.post', $searches, 'post')
@endsection