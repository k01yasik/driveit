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
 */
class Draft extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
