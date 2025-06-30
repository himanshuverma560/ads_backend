<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Delhi' => 'Delhi',
            'Mumbai' => 'Maharashtra',
            'Kolkata' => 'West Bengal',
            'Chennai' => 'Tamil Nadu',
            'Bangalore' => 'Karnataka',
        ];

        foreach ($map as $cityName => $stateName) {
            $state = State::firstOrCreate([
                'name' => $stateName,
                'country_id' => 1,
            ]);

            City::firstOrCreate([
                'name' => $cityName,
                'state_id' => $state->id,
            ]);
        }
    }
}
