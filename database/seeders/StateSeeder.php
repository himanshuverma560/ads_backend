<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $country = Country::firstOrCreate(['name' => 'India']);
        $states = ['Delhi', 'Maharashtra', 'West Bengal', 'Tamil Nadu', 'Karnataka'];
        foreach ($states as $name) {
            State::firstOrCreate(['name' => $name, 'country_id' => $country->id]);
        }
    }
}
