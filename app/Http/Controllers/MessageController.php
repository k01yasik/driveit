<?php

namespace App\Http\Controllers;

use App\Events\MessageSaved;
use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\FriendService;

class MessageController extends Controller
{
    public function __construct(
        private FriendService $friendService,
        private MessageService $messageService
    ) {}

    public function store(MessageRequest $request): array
    {
        $validated = $request->validated();
        $user = $request->user();
        abort_unless($this->friendService->areFriends($user->id, $validated['friend_id']), 403);

        $message = $this->messageService->createMessage(
            $user->id,
            $validated['friend_id'],
            clean($validated['message'])
        );

        $messageId = $this->messageService->addMessage($message);
        broadcast(new MessageSaved($message, $messageId));

        return [
            'username' => $user->username,
            'url' => route('user.profile', ['username' => $user->username]),
            'avatar' => $user->profile?->avatar,
            'time' => $message->getCreatedAt()->format('d F, Y H:i'),
            'text' => $message->getText(),
        ];
    }
}
