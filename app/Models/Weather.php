<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'city', 'coordinates', 'weather_condition', 'temperature', 'feels_like',
        'humidity', 'wind_speed'
    ];

    protected function coordinates(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }
}
