<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $message
 * @property bool $is_verified
 * @property int $level
 * @property int|null $parent_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read Post $post
 */
class Comment extends Model
{
    protected $casts = [
        'is_verified' => 'boolean',
        'level' => 'integer',
        'parent_id' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)
            ->locale('ru')
            ->diffForHumans(null, false, false, 1);
    }
}
