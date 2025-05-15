<?php

namespace App\Events;

use App\Entities\Message;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $recipient;
    public User $sender;
    public string $senderProfileUrl;
    public string $formattedCreatedAt;
    public string $messageText;

    public function __construct(Message $message)
    {
        $this->initializeRecipient($message);
        $this->initializeSender($message);
        $this->initializeMessageDetails($message);
    }

    private function initializeRecipient(Message $message): void
    {
        $this->recipient = User::findOrFail($message->getFriendId());
    }

    private function initializeSender(Message $message): void
    {
        $sender = User::with('profile')->findOrFail($message->getUserId());
        $this->sender = $sender;
        $this->senderProfileUrl = route('user.profile', ['username' => $sender->username]);
    }

    private function initializeMessageDetails(Message $message): void
    {
        $this->messageText = $message->getText();
        $this->formattedCreatedAt = $message->getCreatedAt()->toDateTimeString();
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.'.$this->recipient->id);
    }

    public function broadcastWith(): array
    {
        return [
            'sender' => [
                'id' => $this->sender->id,
                'username' => $this->sender->username,
                'profile_url' => $this->senderProfileUrl,
                'avatar' => $this->sender->profile->avatar ?? null,
            ],
            'message' => [
                'text' => $this->messageText,
                'created_at' => $this->formattedCreatedAt,
            ],
        ];
    }
}
