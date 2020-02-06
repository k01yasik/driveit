@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="album-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
                    <span class="album-breadcrumbs-item">/</span>
                    <a href="{{ route('user.albums.index', ['username' => $user->username]) }}" class="album-breadcrumbs-item">{{ __('Albums') }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <a href="{{ route('user.albums.show', ['username' => $user->username, 'albumname' => $album->name]) }}" class="album-breadcrumbs-item">{{ $album->name }}</a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Editing an album') }}</div>
                </div>
                <div class="create-album-form">
                    <form method="POST" action="{{ route('user.albums.update', ['username' => $user->username, 'albumname' => $album->name]) }}">
                        @method('PUT')
                        @csrf
                        <label for="name" class="required">{{ __('Album name')}}</label>
                        <input name="name" id="name" type="text" value="{{$album->name}}" required>
                        <button type="submit" class="button btn-post-height right">{{ __('Update an album') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection