<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class CurrentUser
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

        if ($userRequest->id !== Auth::id()) {
            return abort(403, 'You are not the owner of this profile');
        }
        return $next($request);
    }
}
