<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Entities\Message as MessageEntity;
use App\Message as MessageModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class MessageRepository implements MessageRepositoryInterface
{
    public function add(MessageEntity $messageEntity): int
    {
        return MessageModel::create($messageEntity->toArray())->id;
    }

    public function getThreads(int $userId): array
    {
        $incoming = MessageModel::query()->where('friend_id', $userId)
            ->selectRaw('user_id AS peer_id, id, CASE WHEN new THEN 1 ELSE 0 END AS unread');
        $outgoing = MessageModel::query()->where('user_id', $userId)->where('friend_id', '<>', $userId)
            ->selectRaw('friend_id AS peer_id, id, 0 AS unread');

        $summaries = MessageModel::query()->fromSub($incoming->unionAll($outgoing), 'participants')
            ->selectRaw('peer_id, MAX(id) AS latest_id, SUM(unread) AS unread_count')
            ->groupBy('peer_id')->orderByDesc('latest_id')->toBase()->get();
        $peers = User::with('profile')->whereKey($summaries->pluck('peer_id')->all())->get()->keyBy('id');
        $latest = MessageModel::whereKey($summaries->pluck('latest_id')->all())->get()->keyBy('id');

        return $summaries->mapWithKeys(fn ($summary) => [$summary->peer_id => [
            'user' => $peers[$summary->peer_id],
            'latest' => $latest[$summary->latest_id],
            'unread' => (int) $summary->unread_count,
        ]])->all();
    }

    public function getUnreadCount(int $userId): int
    {
        return MessageModel::where('friend_id', $userId)->where('new', true)->count();
    }

    public function markRead(int $userId, int $senderId, int $messageId, bool $through = false): void
    {
        MessageModel::where('friend_id', $userId)->where('user_id', $senderId)
            ->where('id', $through ? '<=' : '=', $messageId)->where('new', true)
            ->update(['new' => false]);
    }

    public function getMessages(int $currentUserId, int $friendId): array
    {
        return MessageModel::with('user.profile')
            ->where(function (Builder $query) use ($currentUserId, $friendId) {
                $query->where('user_id', $currentUserId)
                    ->where('friend_id', $friendId);
            })
            ->orWhere(function (Builder $query) use ($currentUserId, $friendId) {
                $query->where('user_id', $friendId)
                    ->where('friend_id', $currentUserId);
            })
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->toArray();
    }
}
