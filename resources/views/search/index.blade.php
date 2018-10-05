@extends('layouts.main')

@section('content')
    <div class="all-posts">
        <div class="all-posts-item">{{ __('Searching results') }}</div>
    </div>
    @each('components.post', $searches, 'post')
@endsection