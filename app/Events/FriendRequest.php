<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class FriendRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $friend;
    public $urlSender;
    public $avatar;

    /**
     * Create a new event instance.
     *
     * @return void
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
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->friend->id);
    }
}
