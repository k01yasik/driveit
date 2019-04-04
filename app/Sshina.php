<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sshina extends Model
{
    public function category() {
        return $this->belongsTo('App\SshinaCategory', 'category_id', 'category_id');
    }
}
