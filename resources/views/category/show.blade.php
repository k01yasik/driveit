@extends('layouts.main')

@section('content')
    @each('components.post', $posts, 'post')
@endsection