<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        City::query()->insert([
            ['name' => 'Dubai', 'country' => 'UAE'],
            ['name' => 'Abu Dhabi', 'country' => 'UAE'],
            ['name' => 'Sharjah', 'country' => 'UAE'],
            ['name' => 'London', 'country' => 'UK'],
            ['name' => 'New York', 'country' => 'USA'],
            ['name' => 'Tokiyo', 'country' => 'Japan'],
        ]);
    }
}
