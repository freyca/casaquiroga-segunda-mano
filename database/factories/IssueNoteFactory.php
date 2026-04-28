<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Issue;
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
        return [
            'issue_id' => Issue::factory(),
            'user_id' => User::factory()->admin(),
            'text' => $this->faker->paragraphs(2, true),
        ];
    }
}
