<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SshinaCategory extends Model
{
    public function offers() {
        return $this->hasMany('App\Sshina', 'category_id', 'category_id');
    }
}
