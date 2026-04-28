<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Models\Issue;
use App\Models\Machine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Issue>
 */
final class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->user(),
            'order_id' => Order::factory(),
            'machine_id' => Machine::factory(),

            'type' => $this->faker->randomElement(IssueType::cases()),
            'priority' => $this->faker->randomElement(IssuePriority::cases()),
            'status' => $this->faker->randomElement(IssueStatus::cases()),

            'description' => $this->faker->paragraph(),
            'just_arrived' => $this->faker->boolean(),
            'observations' => $this->faker->optional()->sentence(),

            'images' => $this->faker->optional()->randomElements([
                'image1.jpg',
                'image2.jpg',
                'image3.jpg',
            ], $this->faker->numberBetween(0, 3)),
        ];
    }
}
