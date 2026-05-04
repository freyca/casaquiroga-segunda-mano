<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderType;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
final class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => mb_strtoupper($this->faker->unique()->bothify('ORD-#####')),
            'type' => $this->faker->randomElement(OrderType::cases()),
        ];
    }
}
