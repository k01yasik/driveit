<?php

namespace App\Actions\Messages;

use App\Events\MessageSaved;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Contracts\Auth\Authenticatable;

class StoreMessageAction
{
    public function __construct(
        private MessageService $messageService,
        private UserService $userService
    ) {}

    public function execute(array $data, Authenticatable $user): array
    {
        $message = $this->messageService->createMessage(
            $user->id,
            $data['friend_id'],
            clean($data['message'])
        );

        $this->messageService->saveMessage($message);
        
        broadcast(new MessageSaved($message));

        return [
            'username' => $user->username,
            'url' => route('user.profile', $user->username),
            'avatar' => $user->profile->avatar,
            'time' => $message->getCreatedAt()->format('d F, Y H:i'),
            'text' => $message->getMessageText()
        ];
    }
}
