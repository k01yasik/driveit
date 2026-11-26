<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = ['make', 'model', 'year', 'album_id'];

    protected $casts = ['odometer_km' => 'integer'];

    public function maintenanceReminders(): HasMany
    {
        return $this->hasMany(MaintenanceReminder::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
