<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Draft
 *
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $slug
 * @property string|null $title
 * @property string|null $description
 * @property string|null $name
 * @property string|null $caption
 * @property string|null $body
 * @property string|null $image_path
 * @property int $is_published
 * @property string|null $date_published
 * @property int $user_id
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereDatePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Draft whereViews($value)
 */
class Draft extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
