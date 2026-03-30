<?php

namespace Database\Factories;

use App\Models\TallerReparacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TallerReparacion>
 */
class TallerReparacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->company(),
        ];
    }
}
