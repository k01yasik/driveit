<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $sender,
        public User $recipient,
        public string $senderProfileUrl,
        public ?string $senderAvatar
    ) {
        $this->senderProfileUrl = route('user.profile', ['username' => $sender->username]);
        $this->senderAvatar = $sender->profile->avatar ?? null;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.'.$this->recipient->id);
    }
}
