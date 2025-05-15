<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Entities\Message as MessageEntity;
use App\Models\Message as MessageModel;
use Illuminate\Database\Eloquent\Builder;

class MessageRepository implements MessageRepositoryInterface
{
    public function add(MessageEntity $messageEntity): void
    {
        MessageModel::create($messageEntity->toArray());
    }

    public function getMessages(int $currentUserId, int $friendId): array
    {
        return MessageModel::with(['user', 'user.profile', 'friend', 'friend.profile'])
            ->where(function (Builder $query) use ($currentUserId, $friendId) {
                $query->where('user_id', $currentUserId)
                    ->where('friend_id', $friendId);
            })
            ->orWhere(function (Builder $query) use ($currentUserId, $friendId) {
                $query->where('user_id', $friendId)
                    ->where('friend_id', $currentUserId);
            })
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }
}
