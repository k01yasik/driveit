@extends('layouts.main')

@section('content')
    <h1>{{ __('Edit comment') }}</h1>
    <x-comment-edit-form :comment="$comment" :action="$action" :back="$back" />
@endsection
