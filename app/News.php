<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Publishable;

class News extends Model
{
    use SoftDeletes, Publishable;

    public const STATUS_PUBLISHED = 1;
    public const STATUS_DRAFT = 0;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'name',
        'caption',
        'body',
        'image_path',
        'is_published',
        'date_published',
        'user_id',
        'views'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'date_published' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', self::STATUS_PUBLISHED)
            ->whereNotNull('date_published')
            ->where('date_published', '<=', now());
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
