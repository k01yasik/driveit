<?php

namespace App\Http\Controllers;

use App\Events\MessageSaved;
use App\Repositories\CachedUserRepository;
use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\UserService;

class MessageController extends Controller
{
    protected UserService $userService;
    protected MessageService $messageService;

    public function __construct(UserService $userService, MessageService $messageService)
    {
        $this->userService = $userService;
        $this->messageService = $messageService;
    }

    public function store(MessageRequest $request) {

        $data = $request->validated();

        $friendId = $data['friend_id'];
        $messageText = clean($data['message']);
        $username = $data['username'];

        $user = $this->userService->getMessageUser($username);

        $message = $this->messageService->create($user['id'], $friendId, $messageText);

        $this->messageService->add($message);

        broadcast(new MessageSaved($message));

        return array(
            'username' => $username,
            'url' => route('user.profile', array('username' => $username)),
            'avatar' => $user['profile']['avatar'],
            'time' => $message->getCreatedAt(),
            'text' => $message->getMessageText()
        );
    }
}
