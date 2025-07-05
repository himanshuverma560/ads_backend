<?php

namespace Database\Factories;

use App\Models\PageScript;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageScriptFactory extends Factory
{
    protected $model = PageScript::class;

    public function definition(): array
    {
        return [
            'page_type' => 'home',
            'script' => 'console.log("test");',
            'position' => $this->faker->unique()->numberBetween(1, 100),
        ];
    }
}
