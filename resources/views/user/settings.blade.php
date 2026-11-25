@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="profile-block">
                <div class="album-breadcrumbs">
                    <a href="{{ route('user.profile', ['username' => $user['username']]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
                    <span class="album-breadcrumbs-item">/</span>
                    <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Settings') }}</div>
                </div>
                <div class="profile-block-content">
                    @if( $user['profile']['public'])
                        <div class="public-user flex flex-v-center">
                            <svg version="1.1" class="public-user-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="public-user flex flex-v-center">
                            <svg version="1.1" class="public-user-uncheck" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M12.016,15.381h-8.65c-1.558,0-2.826-1.268-2.826-2.825v-9.73C0.54,1.268,1.808,0,3.366,0h8.65
                                        c1.558,0,2.825,1.268,2.825,2.826v9.73C14.841,14.114,13.574,15.381,12.016,15.381z M3.366,1.305
                                        c-0.839,0-1.521,0.683-1.521,1.521v9.73c0,0.838,0.683,1.521,1.521,1.521h8.65c0.839,0,1.521-0.684,1.521-1.521v-9.73
                                        c0-0.839-0.683-1.521-1.521-1.521C12.016,1.305,3.366,1.305,3.366,1.305z"></path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    @endif
                    <div class="profile-block-content-label">{{ __('Public profile?') }}</div>
                    <form method="POST" action="{{ route('user.settings.update', $user['username']) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="public" value="{{ $user['profile']['public'] ? 0 : 1 }}">
                        <button type="submit" class="btn">
                            {{ $user['profile']['public'] ? __('Make profile private') : __('Make profile public') }}
                        </button>
                    </form>
                    @if ($errors->any())
                        <ul role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if (session('profileSaved'))
                        <p role="status">{{ __('Profile saved') }}</p>
                    @endif
                    <h2 class="profile-title">{{ __('Edit profile') }}</h2>
                    <form method="POST" action="{{ route('user.profile.update', $user['username']) }}">
                        @csrf
                        @method('PATCH')
                        @foreach (['first_name' => 'First name', 'last_name' => 'Last name', 'city' => 'City'] as $field => $label)
                            <label for="{{ $field }}">{{ __($label) }}</label>
                            <input id="{{ $field }}" name="{{ $field }}" maxlength="100" value="{{ old($field, $user['profile'][$field] ?? '') }}">
                        @endforeach
                        <label for="about">{{ __('About me') }}</label>
                        <textarea id="about" name="about" maxlength="2000" class="materialize-textarea">{{ old('about', $user['profile']['about'] ?? '') }}</textarea>
                        <button class="btn" type="submit">{{ __('Save profile') }}</button>
                    </form>
                    <h2 class="profile-title">{{ __('Garage') }}</h2>
                    <ul class="request-list">
                        @foreach ($cars as $car)
                            <li class="users-element">
                                <span>{{ $car->make }} {{ $car->model }} @if ($car->year) ({{ $car->year }}) @endif</span>
                                <details>
                                    <summary>{{ __('Edit car') }}</summary>
                                    <form method="POST" action="{{ route('user.garage.update', [$user['username'], $car->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        @include('user.car-fields', ['car' => $car])
                                        <button class="btn" type="submit">{{ __('Save car') }}</button>
                                    </form>
                                </details>
                                <form method="POST" action="{{ route('user.garage.destroy', [$user['username'], $car->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-flat" type="submit">{{ __('Remove car') }}</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('user.garage.store', $user['username']) }}">
                        @csrf
                        @include('user.car-fields', ['car' => null])
                        <button class="btn" type="submit">{{ __('Add car') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection