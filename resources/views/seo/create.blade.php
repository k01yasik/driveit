@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('admin.components.panel')
        </div>
        <div class="col s12 m12 l9">
            <div class="right-panel">
                <div class="breadcrumbs flex flex-v-center">
                    <ul class="flex flex-v-center">
                        <li class="flex flex-v-center">
                            <a href="{{ route('admin.index') }}" class="breadcrumbs-home-link">
                                <svg version="1.1" class="home-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 27.02 27.02" xml:space="preserve">
                                    <g>
                                        <path d="M3.674,24.876c0,0-0.024,0.604,0.566,0.604c0.734,0,6.811-0.008,6.811-0.008l0.01-5.581
                                        c0,0-0.096-0.92,0.797-0.92h2.826c1.056,0,0.991,0.92,0.991,0.92l-0.012,5.563c0,0,5.762,0,6.667,0
                                        c0.749,0,0.715-0.752,0.715-0.752V14.413l-9.396-8.358l-9.975,8.358C3.674,14.413,3.674,24.876,3.674,24.876z"></path>
                                        <path d="M0,13.635c0,0,0.847,1.561,2.694,0l11.038-9.338l10.349,9.28c2.138,1.542,2.939,0,2.939,0
                                        L13.732,1.54L0,13.635z"></path>
                                        <polygon points="23.83,4.275 21.168,4.275 21.179,7.503 23.83,9.752 	"></polygon>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li class="flex flex-v-center"><span>/</span></li>
                        <li class="flex flex-v-center"><a href="{{ route('admin.seo') }}">{{ __('Seo') }}</a></li>
                        <li class="flex flex-v-center"><span>/</span></li>
                        <li class="flex flex-v-center">{{ __('Creating seo') }}</li>
                    </ul>
                </div>
                <div class="main-content-wrapper">
                    <div class="row">
                        <div class="col s12 m8 offset-m2 l8 offset-l2 padding-2 primary-border">
                            @error('route')
                                <div class="alert alert-error">
                                    {{ $message }}
                                </div>
                            @enderror
                            <form method="POST" action="{{ route('seo.store') }}">
                                @csrf
                                <label for="route" class="required">{{ __('Route name:')}}</label>
                                <input name="route" id="route" type="text" autocomplete="off" value="{{ old('route') }}" required>
                                <label for="title" class="required">{{ __('Header title:')}}</label>
                                <input name="title" id="title" type="text" autocomplete="off" value="{{ old('title') }}" required>
                                <label for="description" class="required">{{ __('Header description:')}}</label>
                                <input name="description" id="description" type="text" autocomplete="off" value="{{ old('description') }}" required>
                                <button type="submit" class="button btn-seo-update">{{ __('Creating seo') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection