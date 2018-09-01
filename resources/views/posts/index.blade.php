@extends('layouts.main')

@section('content')
    @each('components.post', $posts, 'post')
    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
@endsection