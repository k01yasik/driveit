<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Carbon;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDatePublishedAttribute($value)
    {
        $date = new Carbon($value);
        Carbon::setLocale('ru');

        return $date->diffForHumans(null,  false, false, 1);
    }
}
