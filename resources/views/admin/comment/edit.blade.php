@extends('layouts.admin')

@section('admin-title', __('Edit comment'))

@section('content')
    <x-comment-edit-form :comment="$comment" :action="$action" :back="$back" />
@endsection
