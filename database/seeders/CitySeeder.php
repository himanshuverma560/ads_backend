<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = ['Delhi', 'Mumbai', 'Kolkata', 'Chennai', 'Bangalore'];

        foreach ($cities as $name) {
            City::firstOrCreate(['name' => $name]);
        }
    }
}
