<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Auth;

class PublicUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $username = $request->username;

        $userRequest = User::where('username', $username)->firstOrFail();

        $profile = $userRequest->profile()->first();

        if ($userRequest->id !== Auth::id() && !$profile->public) {
            abort(403, 'User profile is not public');
        }

        return $next($request);
    }
}
