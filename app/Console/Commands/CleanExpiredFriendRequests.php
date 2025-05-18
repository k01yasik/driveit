<?php

namespace App\Console\Commands;

use App\Models\Friend;
use Illuminate\Console\Command;

class CleanExpiredFriendRequests extends Command
{
    protected $signature = 'friends:clean-expired';
    protected $description = 'Remove expired friend requests';

    public function handle(): int
    {
        $count = Friend::where('confirmed', false)
            ->where('created_at', '<', now()->subDays(config('friends.request_expire_days')))
            ->delete();

        $this->info("Deleted {$count} expired friend requests");
        return 0;
    }
}
