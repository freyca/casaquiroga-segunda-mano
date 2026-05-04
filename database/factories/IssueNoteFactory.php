<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\IssueStatus;
use App\Models\IssueNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IssueNote>
 */
final class IssueNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $previous = $this->faker->randomElement(IssueStatus::cases());

        $new = $this->faker->randomElement(
            array_filter(
                IssueStatus::cases(),
                fn (IssueStatus $case): bool => $case !== $previous
            )
        );

        return [
            'issue_id' => null,
            'user_id' => User::factory()->admin(),
            'description' => $this->faker->paragraphs(2, true),
            'previous_state' => $previous,
            'new_state' => $new,
        ];
    }
}
