@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="right-panel">
                <div class="main-content-wrapper">
                    <h2>{{ __('User info') }} {{$user->username}}</h2>
                    <div class="user-info">
                        <div class="user-info-avatar-block">
                            <img src="{{ $user->profile->avatar }}" class="user-info-avatar-image" />
                        </div>
                        <div class="user-info-username">{{ $user->username }}</div>
                        <div class="user-info-email"><span>Email:</span> {{ $user->email }}</div>
                        @if ($user->email_verified_at)
                            <div class="user-info-date-verified"><span>{{ __('Verified:') }}</span> {{ $user->email_verified_at }}</div>
                        @else
                            <div class="user-info-date-verified"><span>{{ __('Verified:') }}</span> {{ __('User not verified email') }}</div>
                        @endif
                        <div class="info-button-block flex flex-justify-space">
                            <a href="{{ route('admin.users') }}" class="button info-button">{{ __('Back') }}</a>
                            @if ($user->rip)
                                <div class="unban-user-button button info-button" data-id="{{ $user->id }}" data-message="{{ __('Unlocked') }}">{{ __('Unban a user') }}</div>
                            @else
                                <a href="{{ route('admin.user.delete', ['username' => $user->username]) }}" class="button info-button">{{ __('Block a user') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection