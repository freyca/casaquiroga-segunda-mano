<?php

declare(strict_types=1);

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Enums\MachineType;
use App\Enums\OrderType;
use App\Filament\Admin\Resources\Issues\Pages\CreateIssue;
use App\Filament\Admin\Resources\Issues\Pages\EditIssue;
use App\Filament\Admin\Resources\Issues\Pages\ListIssues;
use App\Filament\Admin\Resources\Issues\Pages\ViewIssue;
use App\Models\Issue;
use App\Models\Machine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Str;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('IssueResource', function (): void {
    it('can list issues', function (): void {
        $issues = Issue::factory()->count(3)->create();

        livewire(ListIssues::class)
            ->assertOk()
            ->assertCanSeeTableRecords($issues);
    });

    it('can create an issue', function (): void {
        $employee = User::factory()->employee()->create();
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();
        $orderNumber = 'TEST-'.Str::random(5);

        actingAs($employee);

        livewire(CreateIssue::class)
            ->fillForm([
                'order_number' => $orderNumber,
                'order_type' => OrderType::ORDER,
                'customer_id' => $user->id,
                'machine_id' => $machine->id,
                'type' => IssueType::MALFUNCTION,
                'priority' => IssuePriority::STANDARD,
                'status' => IssueStatus::CREATED,
                'description' => 'Test issue description',
                'just_arrived' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(Issue::query()->whereHas('order', function ($q) use ($orderNumber): void {
            $q->where('number', $orderNumber);
        })->exists())->toBeTrue();

        $issue = Issue::query()->latest()->first();
        expect($issue->order->number)->toBe($orderNumber);
        expect($issue->order->type)->toBe(OrderType::ORDER);
        expect($issue->customer_id)->toBe($user->id);
        expect($issue->machine_id)->toBe($machine->id);
    });

    it('creates an order transactionally when creating an issue', function (): void {
        $employee = User::factory()->employee()->create();
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();

        $orderCountBefore = Order::query()->count();

        actingAs($employee);

        livewire(CreateIssue::class)
            ->fillForm([
                'order_number' => 'TXN-TEST-'.Str::random(5),
                'order_type' => OrderType::ORDER,
                'customer_id' => $user->id,
                'machine_id' => $machine->id,
                'type' => IssueType::MALFUNCTION,
                'priority' => IssuePriority::EXPRESS,
                'status' => IssueStatus::CREATED,
                'description' => 'Transactional test',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(Order::query()->count())->toBe($orderCountBefore + 1);
        expect(Issue::query()->count())->toBe(1);
    });

    it('can edit an issue', function (): void {
        $issue = Issue::factory()->create(['description' => 'Old description']);

        livewire(EditIssue::class, ['record' => $issue->id])
            ->fillForm([
                'order_number' => $issue->order->number,
                'order_type' => $issue->order->type->value,
                'description' => 'New description',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($issue->refresh()->description)->toBe('New description');
    });

    it('can edit the order type when editing an issue', function (): void {
        $issue = Issue::factory()->create();

        livewire(EditIssue::class, ['record' => $issue->id])
            ->fillForm([
                'order_number' => $issue->order->number,
                'order_type' => OrderType::DELIVERY_NOTE->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($issue->refresh()->order->type)->toBe(OrderType::DELIVERY_NOTE);
    });

    it('can view an issue', function (): void {
        actingAs(User::factory()->admin()->create()); // Allows us to show edit button

        $issue = Issue::factory()->create();

        livewire(ViewIssue::class, ['record' => $issue->id])
            ->assertOk();
    });

    it('can change status and create a note from view page', function (): void {
        actingAs(User::factory()->admin()->create()); // Allows us to show edit button

        $issue = Issue::factory()->create([
            'status' => IssueStatus::CREATED,
        ]);

        livewire(ViewIssue::class, ['record' => $issue->id])
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
        livewire(CreateIssue::class)
            ->callFormComponentAction('customer_id', 'createOption', data: [
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'phone' => '123456789',
            ]);

        expect(User::query()->where('email', 'newuser@example.com')->exists())->toBeTrue();
    });

    it('can create a machine from the machine_id select inline form', function (): void {
        livewire(CreateIssue::class)
            ->callFormComponentAction('machine_id', 'createOption', data: [
                'type' => MachineType::LAWN_MOWER->value,
                'name' => 'New Test Machine',
            ]);

        expect(Machine::query()->where('name', 'New Test Machine')->exists())->toBeTrue();
    });

    it('validates the machine inline create form', function (): void {
        livewire(CreateIssue::class)
            ->callFormComponentAction('machine_id', 'createOption', data: [
                'type' => null,
                'name' => null,
            ])
            ->assertHasFormErrors(['type' => 'required', 'name' => 'required'])
            ->assertNotNotified();
    });
});
