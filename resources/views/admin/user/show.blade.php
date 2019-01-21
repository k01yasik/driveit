@extends('layouts.empty')

@section('content')
    @include('admin.components.panel')
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
                <a href="{{ route('admin.users') }}" class="button info-button">{{ __('Back') }}</a>
                @if ($user->rip)
                    <div class="unban-user-button button info-button right" data-id="{{ $user->id }}" data-message="{{ __('Unlocked') }}">{{ __('Unban a user') }}</div>
                @else
                    <a href="{{ route('admin.user.delete', ['username' => $user->username]) }}" class="button info-button right">{{ __('Block a user') }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection