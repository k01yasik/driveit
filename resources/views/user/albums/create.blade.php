@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="album-block">
        <div class="album-breadcrumbs">
            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
            <span class="album-breadcrumbs-item">/</span>
            <a href="{{ route('user.albums.index', ['username' => $user->username]) }}" class="album-breadcrumbs-item">{{ __('Albums') }}</a>
            <span class="album-breadcrumbs-item">/</span>
            <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('New album') }}</div>
        </div>
        <div class="create-album-form">
            <form method="POST" action="{{ route('user.albums.store', ['username' => $user->username]) }}">
                @csrf
                <label for="name" class="required">{{ __('Album name')}}</label>
                <input name="name" id="name" type="text" required>
                <button type="submit" class="button btn-post-height right">{{ __('Create an album') }}</button>
            </form>
        </div>
    </div>
@endsection