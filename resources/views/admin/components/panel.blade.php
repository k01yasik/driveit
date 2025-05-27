<div class="left-panel">
    <div class="avatar">
        <div class="avatar-inner">
            <img src="{{ $user['profile']['avatar'] }}" alt="User avatar">
        </div>
    </div>
    <div class="user-profile-username">
        <a href="{{ route('user.profile', ['username' => $user['username']]) }}">{{ $user['username'] }}</a>
    </div>
    <ul class="panel-menu">
        <li class="@isset($activeItem){{ $activeItem == 'admin.index' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="create-post-li @isset($activeItem){{ $activeItem == 'admin.posts' ? 'active-item' : '' }}@endisset">
            <a href="{{ route('admin.posts') }}">{{ __('Posts') }}</a>
            @if (!isset($create))
                <a href="{{ route('admin.posts.create') }}" data-tippy-content="Создать статью" class="create-post">
                    <svg version="1.1" class="create-post-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 533.333 533.333" style="enable-background:new 0 0 533.333 533.333;"
                    xml:space="preserve">
                        <g>
                        <path d="M516.667,200H333.333V16.667C333.333,7.462,325.871,0,316.667,0h-100C207.462,0,200,7.462,200,16.667V200H16.667
                        C7.462,200,0,207.462,0,216.667v100c0,9.204,7.462,16.666,16.667,16.666H200v183.334c0,9.204,7.462,16.666,16.667,16.666h100
                        c9.204,0,16.667-7.462,16.667-16.666V333.333h183.333c9.204,0,16.667-7.462,16.667-16.666v-100
                        C533.333,207.462,525.871,200,516.667,200z"></path>
                        </g>
                    </svg>
                </a>
            @endif
        </li>
        <li class="expanded-li @isset($activeItem){{ in_array($activeItem, ['admin.users', 'admin.verified', 'admin.unverified', 'admin.banned']) ? 'active-item' : '' }}@endisset">
            <div class="expanded-item">
                <span>{{ __('Users') }}</span>
                <svg version="1.1" class="caret-down @isset($activeItem){{ in_array($activeItem, ['admin.users', 'admin.verified', 'admin.unverified', 'admin.banned']) ? 'rotate-svg' : '' }}@endisset" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                width="444.819px" height="444.819px" viewBox="0 0 444.819 444.819" style="enable-background:new 0 0 444.819 444.819;"
                xml:space="preserve">
                    <g>
                        <path d="M434.252,114.203l-21.409-21.416c-7.419-7.04-16.084-10.561-25.975-10.561c-10.095,0-18.657,3.521-25.7,10.561
                        L222.41,231.549L83.653,92.791c-7.042-7.04-15.606-10.561-25.697-10.561c-9.896,0-18.559,3.521-25.979,10.561l-21.128,21.416
                        C3.615,121.436,0,130.099,0,140.188c0,10.277,3.619,18.842,10.848,25.693l185.864,185.865c6.855,7.23,15.416,10.848,25.697,10.848
                        c10.088,0,18.75-3.617,25.977-10.848l185.865-185.865c7.043-7.044,10.567-15.608,10.567-25.693
                        C444.819,130.287,441.295,121.629,434.252,114.203z"/>
                    </g>
                </svg>
            </div>
            <ul class="sub-level @isset($activeItem){{ in_array($activeItem, ['admin.users', 'admin.verified', 'admin.unverified', 'admin.banned']) ? '' : 'hidden-element' }}@endisset">
                <li class="@isset($activeItem){{ $activeItem == 'admin.users' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.users') }}">{{ __('All users') }}</a></li>
                <li class="@isset($activeItem){{ $activeItem == 'admin.verified' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.verified') }}">{{ __('Verified') }}</a></li>
                <li class="@isset($activeItem){{ $activeItem == 'admin.unverified' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.unverified') }}">{{ __('Unverified') }}</a></li>
                <li class="@isset($activeItem){{ $activeItem == 'admin.banned' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.banned') }}">{{ __('Banned') }}</a></li>
            </ul>
        </li>
        <li class="@isset($activeItem){{ $activeItem == 'admin.comments' ? 'active-item' : '' }}@endisset"><a href="{{ route('admin.comments') }}">{{ __('Comments') }}</a></li>
        <li class="create-post-li @isset($activeItem){{ $activeItem == 'admin.seo' ? 'active-item' : '' }}@endisset">
            <a href="{{ route('admin.seo') }}">{{ __('Seo') }}</a>
            @if (!isset($seo_create))
                <a href="{{ route('seo.create') }}" class="create-post">
                    <svg version="1.1" class="create-post-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 533.333 533.333" style="enable-background:new 0 0 533.333 533.333;"
                         xml:space="preserve">
                        <g>
                            <path d="M516.667,200H333.333V16.667C333.333,7.462,325.871,0,316.667,0h-100C207.462,0,200,7.462,200,16.667V200H16.667
                        C7.462,200,0,207.462,0,216.667v100c0,9.204,7.462,16.666,16.667,16.666H200v183.334c0,9.204,7.462,16.666,16.667,16.666h100
                        c9.204,0,16.667-7.462,16.667-16.666V333.333h183.333c9.204,0,16.667-7.462,16.667-16.666v-100
                        C533.333,207.462,525.871,200,516.667,200z"></path>
                        </g>
                    </svg>
                </a>
            @endif
        </li>
    </ul>
</div>
