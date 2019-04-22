<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
