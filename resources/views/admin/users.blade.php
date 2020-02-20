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
                        <li class="flex flex-v-center">{{ __('User management') }}</li>
                    </ul>
                </div>
                <div class="main-content-wrapper">
                    @foreach($users as $u)
                        <div class="user-block flex flex-v-center flex-justify-space">
                            <div class="user-block-avatar">
                                <a href="{{ route('admin.user.show', ['username' => $u->username]) }}" class="user-block-avatar-link">
                                    <img src="{{ $u->profile->avatar }}" class="user-block-avatar-img circle" />
                                </a>
                                <a href="{{ route('admin.user.show', ['username' => $u->username]) }}" class="user-block-username-link">{{ $u->username }}</a>
                            </div>
                            @if ( $u->email_verified_at)
                                <div class="user-block-checked-button margin-right-1">
                                    <svg version="1.1" class="checked-button-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                                        <path d="m.3,14c-0.2-0.2-0.3-0.5-0.3-0.7s0.1-0.5 0.3-0.7l1.4-1.4c0.4-0.4 1-0.4 1.4,0l.1,.1 5.5,5.9c0.2,0.2 0.5,0.2 0.7,0l13.4-13.9h0.1v-8.88178e-16c0.4-0.4 1-0.4 1.4,0l1.4,1.4c0.4,0.4 0.4,1 0,1.4l0,0-16,16.6c-0.2,0.2-0.4,0.3-0.7,0.3-0.3,0-0.5-0.1-0.7-0.3l-7.8-8.4-.2-.3z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="user-block-checked-button margin-right-1">
                                    <svg version="1.1" class="unchecked-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 15.381 15.381" style="enable-background:new 0 0 15.381 15.381;" xml:space="preserve">
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
                            <a href="{{ route('admin.user.show', ['username' => $u->username]) }}" class="user-block-show-button margin-right-1">
                                <svg version="1.1" class="eye-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <path d="M508.177,245.995C503.607,240.897,393.682,121,256,121S8.394,240.897,3.823,245.995c-5.098,5.698-5.098,14.312,0,20.01
                                        C8.394,271.103,118.32,391,256,391s247.606-119.897,252.177-124.995C513.274,260.307,513.274,251.693,508.177,245.995z M256,361
                                        c-57.891,0-105-47.109-105-105s47.109-105,105-105s105,47.109,105,105S313.891,361,256,361z"></path>
                                    </g>
                                    <g>
                                        <path d="M271,226c0-15.09,7.491-28.365,18.887-36.53C279.661,184.235,268.255,181,256,181c-41.353,0-75,33.647-75,75
                                        c0,41.353,33.647,75,75,75c37.024,0,67.668-27.034,73.722-62.358C299.516,278.367,271,255.522,271,226z"></path>
                                    </g>
                                </svg>
                            </a>
                            @if ($u->rip)
                                <div class="user-block-ban-button">
                                    <svg version="1.1" class="ban-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 439.963 439.963" style="enable-background:new 0 0 439.963 439.963;"
                                         xml:space="preserve">
                                        <path d="M421.836,134.33c-11.611-27.121-27.172-50.487-46.686-70.089c-19.502-19.604-42.824-35.215-69.948-46.825
                                        C278.088,5.806,249.674,0,219.985,0c-29.692,0-58.101,5.809-85.224,17.416c-27.124,11.61-50.441,27.218-69.949,46.825
                                        C45.303,83.843,29.74,107.209,18.13,134.33C6.521,161.453,0.715,189.958,0.715,219.838c0,29.881,5.806,58.432,17.415,85.648
                                        c11.613,27.223,27.172,50.627,46.682,70.236c19.508,19.605,42.825,35.217,69.949,46.818c27.123,11.615,55.531,17.422,85.224,17.422
                                        c29.693,0,58.103-5.807,85.217-17.422c27.124-11.607,50.446-27.213,69.948-46.818c19.514-19.609,35.074-43.014,46.686-70.236
                                        c11.611-27.217,17.412-55.768,17.412-85.648C439.244,189.958,433.447,161.453,421.836,134.33z M90.078,305.198
                                        c-16.94-26.066-25.41-54.532-25.406-85.364c0-28.167,6.949-54.243,20.843-78.227c13.891-23.982,32.738-42.919,56.527-56.818
                                        c23.791-13.894,49.772-20.839,77.943-20.839c31.411,0,59.952,8.661,85.652,25.981L90.078,305.198z M363.013,280.511
                                        c-8.187,19.318-19.219,35.927-33.113,49.823c-13.9,13.895-30.409,24.982-49.539,33.254c-19.13,8.277-39.259,12.422-60.382,12.422
                                        c-30.452,0-58.717-8.466-84.794-25.413l215.273-214.985c16.566,25.505,24.838,53.581,24.838,84.223
                                        C375.291,240.965,371.198,261.187,363.013,280.511z"></path>
                                    </svg>
                                </div>
                            @else
                                <a href="{{ route('admin.user.delete', ['username' => $u->username]) }}" class="user-block-delete-button">
                                    <svg version="1.1" class="delete-button-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 94.926 94.926" style="enable-background:new 0 0 94.926 94.926;"
                                         xml:space="preserve">
                                        <g>
                                            <path d="M55.931,47.463L94.306,9.09c0.826-0.827,0.826-2.167,0-2.994L88.833,0.62C88.436,0.224,87.896,0,87.335,0
                                            c-0.562,0-1.101,0.224-1.498,0.62L47.463,38.994L9.089,0.62c-0.795-0.795-2.202-0.794-2.995,0L0.622,6.096
                                            c-0.827,0.827-0.827,2.167,0,2.994l38.374,38.373L0.622,85.836c-0.827,0.827-0.827,2.167,0,2.994l5.473,5.476
                                            c0.397,0.396,0.936,0.62,1.498,0.62s1.1-0.224,1.497-0.62l38.374-38.374l38.374,38.374c0.397,0.396,0.937,0.62,1.498,0.62
                                            s1.101-0.224,1.498-0.62l5.473-5.476c0.826-0.827,0.826-2.167,0-2.994L55.931,47.463z"></path>
                                        </g>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection