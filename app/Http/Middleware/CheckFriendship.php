// app/Http/Middleware/CheckFriendship.php
<?php

namespace App\Http\Middleware;

use App\Models\Friend;
use Closure;
use Illuminate\Http\Request;

class CheckFriendship
{
    public function handle(Request $request, Closure $next)
    {
        if (Friend::where('user_id', auth()->id())
            ->where('friend_id', $request->route('user'))
            ->where('confirmed', true)
            ->exists()) {
            return $next($request);
        }

        abort(403, 'You are not friends with this user');
    }
}
