<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Post
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
 * @property \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property int|null $categories_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property int|null $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Rating[] $rating
 * @property int|null $rating_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Suggest[] $suggest
 * @property int|null $suggest_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereDatePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereViews($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    public bool $asYouType = true;

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function rating()
    {
        return $this->hasMany('App\Rating');
    }

    public function suggest()
    {
        return $this->hasMany('App\Suggest');
    }

    public function getDatePublishedAttribute($value)
    {
        $date = new Carbon($value);
        Carbon::setLocale('ru');

        return $date->diffForHumans(null,  false, false, 1);
    }

    public function isPublished()
    {
        return $this->is_published == 1;
    }

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'body' => $this->body
        ];
    }
}
