<?php

namespace App\Http\Controllers;

use App\Events\MessageSaved;
use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\UserService;
use App\Entities\Message;

class MessageController extends Controller
{
    private UserService $userService;
    private MessageService $messageService;

    public function __construct(UserService $userService, MessageService $messageService)
    {
        $this->userService = $userService;
        $this->messageService = $messageService;
    }

    public function store(MessageRequest $request): array
    {
        $validated = $request->validated();
        $user = $this->userService->getMessageUser($validated['username']);

        $message = $this->messageService->createMessage(
            $user['id'],
            $validated['friend_id'],
            clean($validated['message'])
        );

        $this->messageService->addMessage($message);
        broadcast(new MessageSaved($message));

        return [
            'username' => $validated['username'],
            'url' => route('user.profile', ['username' => $validated['username']]),
            'avatar' => $user['profile']['avatar'],
            'time' => $message->getCreatedAt()->format('d F, Y H:i'),
            'text' => $message->getText(),
        ];
    }
}
