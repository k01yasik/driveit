<?php

namespace App\Repositories;

use App\Entities\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Queries\MessageQueryBuilder;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class MessageRepository implements MessageRepositoryInterface
{
    private const CACHE_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'messages_';

    public function __construct(
        private MessageQueryBuilder $queryBuilder,
        private CacheRepository $cache
    ) {}

    public function add(Message $message): void
    {
        $this->queryBuilder->create($message->toArray());
        
        // Clear relevant cache
        $this->clearConversationCache(
            $message->getUserId(), 
            $message->getFriendId()
        );
    }

    public function getMessages(int $currentId, int $friendId): array
    {
        $cacheKey = $this->getCacheKey($currentId, $friendId);
        
        return $this->cache->remember($cacheKey, self::CACHE_TTL, function() use ($currentId, $friendId) {
            return $this->queryBuilder
                ->forConversation($currentId, $friendId)
                ->with(['user', 'user.profile', 'friend', 'friend.profile'])
                ->orderBy('created_at')
                ->get()
                ->toArray();
        });
    }
    
    private function getCacheKey(int $userId1, int $userId2): string
    {
        $ids = [$userId1, $userId2];
        sort($ids);
        return self::CACHE_PREFIX . implode('_', $ids);
    }
    
    private function clearConversationCache(int $userId1, int $userId2): void
    {
        $this->cache->forget($this->getCacheKey($userId1, $userId2));
    }
}
