@extends('layouts.profile')

@section('content')
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
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
                        <li class="flex flex-v-center">{{ __('Seo') }}</li>
                    </ul>
                </div>
                <div class="main-content-wrapper">
                    @foreach($allSeo as $so)
                        <div class="item-block flex flex-v-center">
                            <div class="item-block-link">
                                <a href="{{ route('seo.show', ['id' => $so['id']]) }}">{{$so['route_name']}}</a>
                            </div>
                            <a href="{{ route('seo.edit', ['id' => $so['id']]) }}" class="edit-button">
                                <svg version="1.1" class="edit-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
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
                            <div class="delete-button">
                                <form method="POST" action="{{ route('seo.destroy', ['id' => $so['id']]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg version="1.1" class="delete-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"
                                        xml:space="preserve">
                                            <g>
                                            <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
                                            c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
                                            c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
                                            c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
                                            s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"/>
                                            </g>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection