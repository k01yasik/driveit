@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.friends', $user['username']) }}" class="album-breadcrumbs-item">{{ __('Friends') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Friend requests') }}</div>
                </div>
                <div class="profile-block-content">
                    @foreach ([false, true] as $outgoing)
                        <h2 class="profile-title">{{ $outgoing ? __('Outgoing requests') : __('Incoming requests') }}</h2>
                        <ul class="request-list">
                            @forelse (($outgoing ? $outgoingRequests : $friendRequests) as $friendRequest)
                                @php($person = $outgoing ? $friendRequest->recipient : $friendRequest->user)
                                <li class="users-element">
                                    <span class="profile-name">{{ $person->username }}</span>
                                    <div class="flex">
                                        @unless ($outgoing)
                                            <form method="POST" action="{{ route('user.requests.confirmation') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $person->id }}">
                                                <button class="btn-flat" type="submit">{{ __('Accept request') }}</button>
                                            </form>
                                        @endunless
                                        <form method="POST" action="{{ route('user.requests.destroy', [$user['username'], $person->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="outgoing" value="{{ (int) $outgoing }}">
                                            <button class="btn-flat" type="submit">{{ $outgoing ? __('Cancel request') : __('Decline request') }}</button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li>{{ __('No requests') }}</li>
                            @endforelse
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
