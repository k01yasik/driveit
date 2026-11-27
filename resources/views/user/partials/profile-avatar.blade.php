<div class="avatar">
    <div class="avatar-inner circle">
        <img src="{{ $user['profile']['avatar'] ?? asset('storage/avatars/user.svg') }}" alt="">
        @if ($currentUserProfile)
            <div class="change-avatar">
                <button type="button" class="upload-button" aria-label="{{ __('Change avatar') }}">
                    <svg version="1.1" class="upload-button-svg" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 52.756 52.757" style="enable-background:new 0 0 52.756 52.757;"
                         xml:space="preserve">
                    <g>
                        <path d="M26.108,0L15.585,10.524c-1.048,1.024-0.815,1.746,0.649,1.746h5.873l-0.001,12.788c0,2.208,1.79,4,4,4l0,0
                        c2.209,0,4-1.791,4-4l0.001-12.789h5.876c1.462,0.001,1.693-0.723,0.646-1.747L26.108,0z"></path>
                        <path d="M49.027,25.77h-6.049c-0.554,0-1,0.447-1,1v17.939H10.78V26.77c0-0.553-0.447-1-1-1H3.731c-0.553,0-1,0.447-1,1v20.464
                        c0,3.045,2.479,5.522,5.524,5.522h36.248c3.046,0,5.523-2.479,5.523-5.522V26.77C50.027,26.217,49.581,25.77,49.027,25.77z"></path>
                    </g>
                </svg>
                </button>
            </div>
            <form enctype="multipart/form-data" id="change-avatar-form">
                <input type="file" id="change-avatar-input" accept="image/jpeg,image/png" name="change-avatar-image" data-username="{{ $user['username'] }}">
            </form>
        @endif
    </div>
</div>
