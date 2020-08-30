<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Message;
use App\Entities\Message as MessageEntity;

class MessageRepository implements MessageRepositoryInterface
{

    public function add(MessageEntity $messageEntity): void
    {
        $message = new Message;
        $message->user_id = $messageEntity->getUserId();
        $message->text = $messageEntity->getMessageText();
        $message->friend_id = $messageEntity->getFriendId();
        $message->created_at = $messageEntity->getCreatedAt();
        $message->save();
    }

    public function getMessages(int $currentId, int $friendId): array
    {
        return Message::with(['user', 'user.profile', 'friend', 'friend.profile'])
            ->where([['user_id', $currentId], ['friend_id', $friendId]])
            ->orWhere([['user_id', $friendId], ['friend_id', $currentId]])
            ->orderBy('created_at')
            ->get()->toArray();
    }
}