<div class="left-panel">
    <div class="avatar">
        <div class="avatar-inner circle">
            <img src="{{ $user->profile->avatar }}">
        </div>
    </div>
    <div class="user-profile-username">
        <a href="{{ route('user.profile', ['username' => $user->username]) }}">{{ $user->username }}</a>
    </div>
    <ul class="panel-menu">
        <li><a href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="create-post-li">
            <a href="{{ route('admin.posts') }}">{{ __('Posts') }}</a>
            @if (!isset($create))
                <a href="{{ route('admin.posts.create') }}" class="create-post">
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
        <li>
            <div class="expanded-item">{{ __('Users') }}</div>
            <ul class="sub-level">
                <li><a href="{{ route('admin.users') }}">{{ __('All users') }}</a></li>
                <li><a href="{{ route('admin.verified') }}">{{ __('Verified') }}</a></li>
                <li><a href="{{ route('admin.unverified') }}">{{ __('Unverified') }}</a></li>
                <li><a href="{{ route('admin.banned') }}">{{ __('Banned') }}</a></li>
            </ul>
        </li>
        <li><a href="{{ route('admin.comments') }}">{{ __('Comments') }}</a></li>
        <li class="create-post-li">
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