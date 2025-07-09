<?php

namespace Database\Factories;

use App\Models\GoogleAnalytic;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoogleAnalyticFactory extends Factory
{
    protected $model = GoogleAnalytic::class;

    public function definition(): array
    {
        return [
            'code' => '<script>console.log("ga")</script>',
        ];
    }
}

