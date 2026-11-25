<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $sender,
        public User $recipient
    ) {}

    public function broadcastWith(): array
    {
        return [
            'sender' => ['id' => $this->sender->id, 'username' => $this->sender->username],
            'recipient' => ['username' => $this->recipient->username],
            'senderProfileUrl' => route('user.profile', ['username' => $this->sender->username]),
            'senderAvatar' => $this->sender->profile?->avatar,
        ];
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.'.$this->recipient->id);
    }
}
