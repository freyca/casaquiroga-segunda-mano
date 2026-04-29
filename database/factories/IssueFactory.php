<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\UniqueReferenceNumber;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Enums\Role;
use App\Models\Issue;
use App\Models\IssueNote;
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
            'customer_id' => User::factory()->user(),
            'created_by' => User::factory()->employee(),
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

            'reference_number' => UniqueReferenceNumber::create('SAT'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Issue $issue): void {

            $users = User::query()
                ->where('role', Role::Employee)
                ->inRandomOrder()
                ->take(2)
                ->pluck('id');

            // If not enough users exist, create them
            while ($users->count() < 2) {
                $users->push(
                    User::factory()->employee()->create()->id
                );
            }

            foreach ($users as $userId) {
                IssueNote::factory()->create([
                    'issue_id' => $issue->id,
                    'user_id' => $userId,
                ]);
            }
        });
    }
}
