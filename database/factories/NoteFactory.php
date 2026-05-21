<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\IssueStatus;
use App\Enums\SellStatus;
use App\Models\Issue;
use App\Models\Note;
use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
final class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraphs(2, true),
            'user_id' => User::factory()->admin(),
            'noteable_type' => null,
            'noteable_id' => null,
            'previous_state' => null,
            'new_state' => null,
        ];
    }

    public function forIssue(?Issue $issue = null, ?IssueStatus $previous = null, ?IssueStatus $new = null): static
    {
        $issue = $issue ?: Issue::factory();
        $previous = $previous ?: $this->faker->randomElement(IssueStatus::cases());
        $new = $new ?: $this->faker->randomElement(array_filter(IssueStatus::cases(), fn (IssueStatus $case): bool => $case !== $previous));

        return $this->state(fn (): array => [
            'noteable_type' => Issue::class,
            'noteable_id' => $issue,
            'previous_state' => $previous,
            'new_state' => $new,
        ]);
    }

    public function forSecondHandMachine(?SecondHandMachine $machine = null, ?SellStatus $previous = null, ?SellStatus $new = null): static
    {
        $machine = $machine ?: SecondHandMachine::factory();
        $previous = $previous ?: $this->faker->randomElement(SellStatus::cases());
        $new = $new ?: $this->faker->randomElement(array_filter(SellStatus::cases(), fn (SellStatus $case): bool => $case !== $previous));

        return $this->state(fn (): array => [
            'noteable_type' => SecondHandMachine::class,
            'noteable_id' => $machine,
            'previous_state' => $previous,
            'new_state' => $new,
        ]);
    }
}
