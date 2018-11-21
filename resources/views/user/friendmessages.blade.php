@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="profile-block">
        <div class="album-breadcrumbs">
            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
            <span class="album-breadcrumbs-item">/</span>
            <a href="{{ route('user.messages', ['username' => $user->username]) }}" class="album-breadcrumbs-item">{{ __('Messages') }}</a>
            <span class="album-breadcrumbs-item">/</span>
            <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Dialogue') }}</div>
        </div>
        <div class="profile-block-content margin-bottom-2" data-username="{{ $user->username }}" data-friend="{{ $friend->id }}">
            @if ($messages->count() > 0)
                @foreach ($messages as $message)
                    <div class="message-wrapper">
                        <div class="message-header">
                            <a href="{{ route('user.profile', ['username' => $message->user->username]) }}" class="message-header-link"><img src="{{ $message->user->profile->avatar }}" class="message-header-avatar"></a>
                        </div>
                        <div class="message-body {{ $message->new ? 'new-message' : '' }}">
                            <div class="message-body-header">
                                <a href="{{ route('user.profile', ['username' => $message->user->username]) }}" class="message-header-name">{{ $message->user->username }}</a>
                                <div class="message-body-header-time">{{ $message->created_at }}</div>
                            </div>
                            <div class="message-body-content">
                                {!! $message->text !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>{{ __('Have a nice chat!') }}</h3>
            @endif
        </div>
        @include('components.texteditor-mini')
    </div>
@endsection