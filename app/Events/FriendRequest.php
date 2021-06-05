<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\User;
use Illuminate\Support\Facades\Log;

class FriendRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $sender;
    public User $friend;
    public string $urlSender;
    public $avatar;

    /**
     * Create a new event instance.
     *
     * @param User $sender
     * @param User $friend
     */
    public function __construct(User $sender, User $friend)
    {
        $this->sender = $sender;
        $this->friend = $friend;

        $this->urlSender = route('user.profile', ['username' => $sender->username]);
        $this->avatar = $sender->profile()->firstOrFail()->avatar;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('user.'.$this->friend->id);
    }
}
