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
        $username = $request->route('username');
        $user = Auth::user();

        if ($user->username !== $username) {
            $profileUser = $request->attributes->get('profileUser')
                ?? User::where('username', $username)->firstOrFail();
            abort_unless($profileUser->is($user), 403, 'You are not the owner of this profile');
        }

        if (!$request->attributes->has('profileUser')) {
            $request->attributes->set('profileUser', $user);
        }

        return $next($request);
    }
}
