@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="right-panel">
                <div class="main-content-wrapper">
                    <h2>{{ __('Confirm block a user') }} {{$user->username}}</h2>
                    <div class="flex flex-justify-space">
                        <div class="confirm-delete-button button confirm-button right" data-id="{{ $user->id }}" data-message="{{ __('User successfully blocked') }}" data-button="{{ __('Back') }}">{{ __('Confirm block') }}</div>
                        <a href="{{ route('admin.users') }}" class="cancel-delete-button button confirm-button">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection