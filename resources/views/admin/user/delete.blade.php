@extends('layouts.empty')

@section('content')
    @include('admin.components.panel')
    <div class="right-panel">
        <div class="main-content-wrapper">
            <h2>{{ __('Confirm block a user') }} {{$user->username}}</h2>
            <div class="confirm-delete-button button confirm-button right" data-id="{{ $user->id }}">{{ __('Confirm block') }}</div>
            <a href="{{ route('admin.users') }}" class="cancel-delete-button button confirm-button">{{ __('Cancel') }}</a>
        </div>
    </div>
@endsection