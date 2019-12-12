<?php

namespace App\Http\Controllers;

use App\Events\MessageSaved;
use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    protected $userRepository;
    protected $messageRepository;

    public function __construct(CachedUserRepository $userRepository, MessageRepositoryInterface $messageRepository)
    {
        $this->userRepository = $userRepository;
        $this->messageRepository = $messageRepository;
    }

    public function store(MessageRequest $request) {

        $data = $request->validated();

        $friend_id = $data['friend_id'];
        $message = clean($data['message']);
        $username = $data['username'];

        $user = $this->userRepository->getMessageUser($username);

        $messageEntry = $this->messageRepository->store($user->id, $friend_id, $message);

        broadcast(new MessageSaved($messageEntry));

        return [
            'username' => $username,
            'url' => route('user.profile', ['username' => $username]),
            'avatar' => $user->profile->avatar,
            'time' => $messageEntry->created_at,
            'text' => $messageEntry->text
        ];
    }
}
