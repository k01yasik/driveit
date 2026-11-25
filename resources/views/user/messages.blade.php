@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.profile', $user['username']) }}" class="album-breadcrumbs-item">{{ __('Profile') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Messages') }}</div>
                </div>
                <div class="profile-block-content">
                    <ul class="request-list">
                        @forelse ($threads as $thread)
                            <li class="users-element">
                                <a href="{{ route('user.friend.messages', [$user['username'], $thread['user']->username]) }}" class="users-element-link">
                                    <div class="profile-link"><img src="{{ $thread['user']->profile?->avatar }}" class="avatar-image" alt=""></div>
                                    <div>
                                        <span class="profile-name">{{ $thread['user']->username }}</span>
                                        @if ($thread['latest'])
                                            @php($preview = trim(html_entity_decode(strip_tags(str_replace('<', ' <', $thread['latest']->text)), ENT_QUOTES | ENT_HTML5, 'UTF-8')))
                                            <div>{{ $preview === '' ? __('Attachment') : \Illuminate\Support\Str::limit($preview, 90) }}</div>
                                        @endif
                                    </div>
                                    @if ($thread['unread'])
                                        <strong class="right">{{ __('Unread messages: :count', ['count' => $thread['unread']]) }}</strong>
                                    @endif
                                </a>
                            </li>
                        @empty
                            <li>{{ __('No results found') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
