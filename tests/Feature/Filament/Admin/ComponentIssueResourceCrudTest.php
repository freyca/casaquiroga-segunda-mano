<?php

declare(strict_types=1);

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\MachineType;
use App\Filament\Admin\Resources\ComponentIssues\Pages\CreateComponentIssue;
use App\Filament\Admin\Resources\ComponentIssues\Pages\EditComponentIssue;
use App\Filament\Admin\Resources\ComponentIssues\Pages\ListComponentIssues;
use App\Filament\Admin\Resources\ComponentIssues\Pages\ViewComponentIssue;
use App\Models\ComponentIssue;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Str;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('ComponentIssueResource', function (): void {
    it('can list component issues', function (): void {
        $issues = ComponentIssue::factory()->count(3)->create();

        livewire(ListComponentIssues::class)
            ->assertOk()
            ->assertCanSeeTableRecords($issues);
    });

    it('can create a component issue', function (): void {
        $employee = User::factory()->employee()->create();
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();
        $orderNumber = 'TEST-'.Str::random(5);

        actingAs($employee);

        livewire(CreateComponentIssue::class)
            ->fillForm([
                'customer_id' => $user->id,
                'machine_id' => $machine->id,
                'priority' => IssuePriority::STANDARD,
                'status' => IssueStatus::CREATED,
                'description' => 'Test issue description',
                'just_arrived' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        $issue = ComponentIssue::query()->latest()->first();
        expect($issue->customer_id)->toBe($user->id);
        expect($issue->machine_id)->toBe($machine->id);
    });

    it('can edit a component issue', function (): void {
        $issue = ComponentIssue::factory()->create(['description' => 'Old description']);

        livewire(EditComponentIssue::class, ['record' => $issue->id])
            ->fillForm([
                'description' => 'New description',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($issue->refresh()->description)->toBe('New description');
    });

    it('can view a component issue', function (): void {
        actingAs(User::factory()->admin()->create()); // Allows us to show edit button

        $issue = ComponentIssue::factory()->create();

        livewire(ViewComponentIssue::class, ['record' => $issue->id])
            ->assertOk();
    });

    it('can change status and create a note from view page', function (): void {
        actingAs(User::factory()->admin()->create()); // Allows us to show edit button

        $issue = ComponentIssue::factory()->create([
            'status' => IssueStatus::CREATED,
        ]);

        livewire(ViewComponentIssue::class, ['record' => $issue->id])
            ->callAction('change_status', data: [
                'issue_status' => IssueStatus::IN_PROGRESS,
                'note_description' => 'Status changed to in progress',
            ]);

        $issue->refresh();

        expect($issue->status)->toBe(IssueStatus::IN_PROGRESS);

        $note = $issue->notes->last();

        expect($note)->not->toBeNull();
        expect($note->description)->toBe('Status changed to in progress');
        expect($note->previous_state)->toBe(IssueStatus::CREATED);
        expect($note->new_state)->toBe(IssueStatus::IN_PROGRESS);
    });

    it('can create a user from the customer_id select inline form', function (): void {
        livewire(CreateComponentIssue::class)
            ->callFormComponentAction('customer_id', 'createOption', data: [
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'phone' => '123456789',
            ]);

        expect(User::query()->where('email', 'newuser@example.com')->exists())->toBeTrue();
    });

    it('can create a machine from the machine_id select inline form', function (): void {
        livewire(CreateComponentIssue::class)
            ->callFormComponentAction('machine_id', 'createOption', data: [
                'type' => MachineType::LAWN_MOWER->value,
                'name' => 'New Test Machine',
            ]);

        expect(Machine::query()->where('name', 'New Test Machine')->exists())->toBeTrue();
    });

    it('validates the machine inline create form', function (): void {
        livewire(CreateComponentIssue::class)
            ->callFormComponentAction('machine_id', 'createOption', data: [
                'type' => null,
                'name' => null,
            ])
            ->assertHasFormErrors(['type' => 'required', 'name' => 'required'])
            ->assertNotNotified();
    });
});
