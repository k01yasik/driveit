<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Rip
 *
 * @property int $id
 * @property int $user_id
 * @property string $rip_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip whereRipDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rip whereUserId($value)
 * @mixin \Eloquent
 */
class Rip extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
