<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\UniqueReferenceNumber;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\Role;
use App\Models\ComponentIssue;
use App\Models\Issue;
use App\Models\Machine;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComponentIssue>
 */
final class ComponentIssueFactory extends Factory
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
            'machine_id' => Machine::factory(),

            'priority' => $this->faker->randomElement(IssuePriority::cases()),
            'status' => $this->faker->randomElement(IssueStatus::cases()),

            'description' => $this->faker->paragraph(),
            'just_arrived' => $this->faker->boolean(),

            'images' => $this->faker->optional()->randomElements([
                'image1.jpg',
                'image2.jpg',
                'image3.jpg',
            ], $this->faker->numberBetween(0, 3)),

            'reference_number' => UniqueReferenceNumber::create('REC'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (ComponentIssue $issue): void {
            $users = User::query()
                ->where('role', Role::Employee)
                ->inRandomOrder()
                ->take(2)
                ->pluck('id');

            while ($users->count() < 2) {
                $users->push(
                    User::factory()->employee()->create()->id
                );
            }

            foreach ($users as $userId) {
                Note::factory()->create([
                    'noteable_id' => $issue->id,
                    'noteable_type' => Issue::class,
                    'user_id' => $userId,
                    'previous_state' => $issue->status,
                    'new_state' => $issue->status,
                ]);
            }
        });
    }
}
