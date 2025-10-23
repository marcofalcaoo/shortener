<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    public function definition(): array
    {
        return [
            'original_url' => fake()->url(),
            'short_code' => Url::generateShortCode(),
            'access_count' => fake()->numberBetween(0, 100),
        ];
    }
}
