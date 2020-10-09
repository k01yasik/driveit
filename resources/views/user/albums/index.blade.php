@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m12 l3 sm-margin-bottom-2">
            @include('components.profile')
        </div>
        <div class="col s12 m12 l9">
            <div class="album-block">
            <div class="album-breadcrumbs">
                <a href="{{ route('user.profile', ['username' => $user['username']]) }}" class="album-breadcrumbs-item"><div>{{ __('Profile') }}</div></a>
                <span class="album-breadcrumbs-item">/</span>
                <div class="album-breadcrumbs-item breadcrumbs-bold-item">{{ __('Albums') }}</div>
                <a href="{{ route('user.albums.create', ['username' => $user['username']]) }}" class="right create-album" title="{{ __('Create an album') }}">
                    <svg version="1.1" class="create-album-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 533.333 533.333" style="enable-background:new 0 0 533.333 533.333;"
                    xml:space="preserve">
                        <g>
                            <path d="M516.667,200H333.333V16.667C333.333,7.462,325.871,0,316.667,0h-100C207.462,0,200,7.462,200,16.667V200H16.667
                            C7.462,200,0,207.462,0,216.667v100c0,9.204,7.462,16.666,16.667,16.666H200v183.334c0,9.204,7.462,16.666,16.667,16.666h100
                            c9.204,0,16.667-7.462,16.667-16.666V333.333h183.333c9.204,0,16.667-7.462,16.667-16.666v-100
                            C533.333,207.462,525.871,200,516.667,200z"></path>
                        </g>
                    </svg>
                </a>
            </div>
            @foreach($user['albums'] as $album)
                <div class="album-wrapper">
                    <div class="album-caption">
                        <a href="{{ route('user.albums.show', ['username' => $user['username'], 'albumname' => $album['name']]) }}">{{ $album['name'] }}</a>

                        <a href="{{ route('user.albums.edit', ['username' => $user['username'], 'albumname' => $album['name']]) }}" class="edit-album right">
                            <svg version="1.1" class="edit-album-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M397.736,78.378c6.824,0,12.358-5.533,12.358-12.358V27.027C410.094,12.125,397.977,0,383.08,0H121.641
                                        c-3.277,0-6.42,1.303-8.739,3.62L10.527,105.995c-2.317,2.317-3.62,5.461-3.62,8.738v370.239C6.908,499.875,19.032,512,33.935,512
                                        h349.144c14.897,0,27.014-12.125,27.014-27.027V296.289c0.001-6.824-5.532-12.358-12.357-12.358
                                        c-6.824,0-12.358,5.533-12.358,12.358v188.684c0,1.274-1.031,2.311-2.297,2.311H33.936c-1.274,0-2.311-1.037-2.311-2.311v-357.88
                                        h75.36c14.898,0,27.016-12.12,27.016-27.017V24.716H383.08c1.267,0,2.297,1.037,2.297,2.311V66.02
                                        C385.377,72.845,390.911,78.378,397.736,78.378z M109.285,100.075c0,1.269-1.032,2.301-2.3,2.301H49.107l60.178-60.18V100.075z"></path>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path d="M492.865,100.396l-14.541-14.539c-16.304-16.304-42.832-16.302-59.138,0L303.763,201.28H103.559
                                        c-6.825,0-12.358,5.533-12.358,12.358c0,6.825,5.533,12.358,12.358,12.358h175.488l-74.379,74.379H103.559
                                        c-6.825,0-12.358,5.533-12.358,12.358s5.533,12.358,12.358,12.358h76.392l-0.199,0.199c-1.508,1.508-2.598,3.379-3.169,5.433
                                        l-19.088,68.747h-53.936c-6.825,0-12.358,5.533-12.358,12.358s5.533,12.358,12.358,12.358h63.332c0.001,0,2.709-0.306,3.107-0.41
                                        c0.065-0.017,77.997-21.642,77.997-21.642c2.054-0.57,3.926-1.662,5.433-3.169l239.438-239.435
                                        C509.168,143.228,509.168,116.7,492.865,100.396z M184.644,394.073l10.087-36.326l26.24,26.24L184.644,394.073z M244.69,372.752
                                        l-38.721-38.721l197.648-197.648l38.722,38.721L244.69,372.752z M475.387,142.054l-15.571,15.571l-38.722-38.722l15.571-15.571
                                        c6.669-6.668,17.517-6.667,24.181,0l14.541,14.541C482.054,124.54,482.054,135.388,475.387,142.054z"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="album-cover">
                        @if ($album['cover'])
                            <img src="{{ $album['cover'] }}" alt="{{ $album['name'] }}">
                        @else
                            <img src="/storage/cover/album-cover.jpg" alt="{{ $album['name'] }}">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
@endsection