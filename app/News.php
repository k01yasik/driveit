<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\News
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $name
 * @property string $caption
 * @property string $body
 * @property string $image_path
 * @property int $is_published
 * @property string|null $date_published
 * @property int|null $user_id
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static Builder|News newModelQuery()
 * @method static Builder|News newQuery()
 * @method static Builder|News query()
 * @method static Builder|News whereBody($value)
 * @method static Builder|News whereCaption($value)
 * @method static Builder|News whereCreatedAt($value)
 * @method static Builder|News whereDatePublished($value)
 * @method static Builder|News whereDescription($value)
 * @method static Builder|News whereId($value)
 * @method static Builder|News whereImagePath($value)
 * @method static Builder|News whereIsPublished($value)
 * @method static Builder|News whereName($value)
 * @method static Builder|News whereSlug($value)
 * @method static Builder|News whereTitle($value)
 * @method static Builder|News whereUpdatedAt($value)
 * @method static Builder|News whereUserId($value)
 * @method static Builder|News whereViews($value)
 * @mixin \Eloquent
 * @method static Builder|\News published()
 */
class News extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }


    /**
     * @param Builder $query
     * @return Builder;
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
