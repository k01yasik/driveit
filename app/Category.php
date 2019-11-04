<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property string $displayname
 * @property int $has_child
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDisplayname($value)
 * @method static Builder|Category whereHasChild($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category hasChild()
 * @mixin \Eloquent
 */
class Category extends Model
{
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    /**
     * @param Builder $query
     * @return Builder;
     */
    public function scopeHasChild($query)
    {
        return $query->where('has_child', 0);
    }
}
