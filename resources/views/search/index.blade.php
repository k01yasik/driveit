@extends('layouts.main')

@section('content')
    <section>
        <div class="all-posts">
            <h1 class="all-posts-item">{{ __('Search results for phrase:') }} "{{ $query }}"</h1>
        </div>
        @each('components.post', $searches, 'post')
    </section>
@endsection