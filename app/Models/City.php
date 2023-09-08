<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country'];

    protected $casts = ['name' => 'string', 'country' => 'string'];

    public function weathers(): HasMany
    {
        return $this->hasMany(Weather::class, 'city', 'id');
    }
}
