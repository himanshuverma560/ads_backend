<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = ['India'];
        foreach ($countries as $name) {
            Country::firstOrCreate(['name' => $name]);
        }
    }
}
