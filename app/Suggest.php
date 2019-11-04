<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Suggest
 *
 * @property int $id
 * @property int $post_id
 * @property int $suggest
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest whereSuggest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Suggest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Suggest extends Model
{
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
