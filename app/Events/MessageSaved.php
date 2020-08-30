<?php

namespace App\Events;

use App\Entities\Message;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class MessageSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userTo;
    public $userFrom;
    public $url;
    public string $createdAt;
    public int $text;

    public function __construct(Message $message)
    {
        $this->userTo = User::find($message->getFriendId());
        $user = User::with('profile')->find($message->getUserId());
        $this->userFrom = $user;
        $this->url = route('user.profile', ['username' => $user->username]);

        $this->createdAt = Carbon::createFromTimestamp($message->getCreatedAt())->toDateTimeString();
        $this->text = $message->getMessageText();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->userTo->id);
    }
}
