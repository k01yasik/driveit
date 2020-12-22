@extends('layouts.main')

@section('content')
    <section>
        <div class="all-posts">
            <h2 class="all-posts-item">{{ __('Search results for phrase:') }} "{{ $query }}"</h2>
        </div>
        @each('components.post', $searches, 'post')
    </section>
@endsection