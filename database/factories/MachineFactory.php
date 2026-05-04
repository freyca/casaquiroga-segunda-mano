<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MachineType;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Machine>
 */
final class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'type' => $this->faker->randomElement(MachineType::cases()),
        ];
    }
}
