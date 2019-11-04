<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Friend
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $owner
 * @property int $confirmed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Friend whereUserId($value)
 * @mixin \Eloquent
 */
class Friend extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
}
