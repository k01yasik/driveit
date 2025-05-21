<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    protected $fillable = [
        'user_id',
        'friend_id',
        'owner',
        'confirmed',
    ];

    protected $casts = [
        'owner' => 'boolean',
        'confirmed' => 'boolean',
    ];

    public function scopePendingRequestsToUser($query, int $userId)
    {
        return $query->where([
            ['friend_id', $userId],
            ['confirmed', false],
            ['owner', true],
        ]);
    }

    public function scopeConfirmedFriendsOfUser($query, int $userId)
    {
        return $query->where('friend_id', $userId)
            ->where('confirmed', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
