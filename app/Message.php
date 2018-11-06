<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function friend()
    {
        return $this->belongsTo('App\User', 'friend_id');
    }

    public function getCreatedAtAttribute($value)
    {
        $date = new Carbon($value);

        Carbon::setLocale('ru');

        setlocale(LC_TIME, 'ru_RU.UTF-8');

        return $date->formatLocalized('%e %B, %G %H:%M');
    }
}
