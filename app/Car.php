<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $fillable = ['make', 'model', 'year', 'album_id'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
