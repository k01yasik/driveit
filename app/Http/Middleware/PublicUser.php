<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
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
        $username = $request->route('username');

        $userRequest = User::where('username', $username)->firstOrFail();

        if ($userRequest->id !== Auth::id() && !$userRequest->profile?->public) {
            abort(403, 'User profile is not public');
        }

        $request->attributes->set('profileUser', $userRequest);

        return $next($request);
    }
}
