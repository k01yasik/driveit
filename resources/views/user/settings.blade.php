@extends('layouts.empty')

@section('content')
    @include('components.profile')
    <div class="user-profile-content">
        <div class="public-profile-caption">{{ __('Settings') }}</div>
        <div class="public-profile">
            <p>{{ __('Public profile') }}</p>
        </div>
    </div>
@endsection