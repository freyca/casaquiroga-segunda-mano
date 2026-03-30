<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Marca>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->words(2, true),
        ];
    }
}
