<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceReminder extends Model
{
    protected $fillable = ['title', 'due_on', 'due_odometer_km'];

    protected $casts = [
        'due_on' => 'date',
        'due_odometer_km' => 'integer',
        'completed_at' => 'datetime',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeForOwner(Builder $query, int $userId): Builder
    {
        return $query->whereHas('car', fn (Builder $car) => $car->where('user_id', $userId));
    }

    public function scopeDue(Builder $query): Builder
    {
        return $query->whereNull('completed_at')
            ->where(function (Builder $query) {
                $query->whereDate('due_on', '<=', today()->toDateString())
                    ->orWhereHas('car', fn (Builder $car) => $car->whereColumn(
                        'cars.odometer_km', '>=', 'maintenance_reminders.due_odometer_km'
                    ));
            });
    }
}
