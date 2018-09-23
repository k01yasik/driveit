<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    public $asYouType = true;

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

    public function getDatePublishedAttribute($value)
    {
        $date = new Carbon($value);
        Carbon::setLocale('ru');

        return $date->diffForHumans(null,  false, false, 1);
    }

    public function isPublished()
    {
        return $this->is_published = 1;
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
