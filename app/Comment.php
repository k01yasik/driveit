<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function getCreatedAtAttribute($value)
    {
        $date = new Carbon($value);
        Carbon::setLocale('ru');

        return $date->diffForHumans(null,  false, false, 1);
    }
}
