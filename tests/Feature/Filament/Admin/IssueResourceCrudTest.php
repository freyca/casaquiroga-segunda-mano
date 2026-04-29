<?php

declare(strict_types=1);

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
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
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();
        $orderNumber = 'TEST-'.Str::random(5);

        livewire(CreateIssue::class)
            ->fillForm([
                'order_number' => $orderNumber,
                'order_type' => OrderType::ORDER,
                'user_id' => $user->id,
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
        expect($issue->user_id)->toBe($user->id);
        expect($issue->machine_id)->toBe($machine->id);
    });

    it('creates an order transactionally when creating an issue', function (): void {
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();

        $orderCountBefore = Order::query()->count();

        livewire(CreateIssue::class)
            ->fillForm([
                'order_number' => 'TXN-TEST-'.Str::random(5),
                'order_type' => OrderType::ORDER,
                'user_id' => $user->id,
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
        $issue = Issue::factory()->create();

        livewire(ViewIssue::class, ['record' => $issue->id])
            ->assertOk();
    });

    it('can change status and create a note from view page', function (): void {
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

    it('issue has correct default values', function (): void {
        $issue = Issue::factory()->create();

        expect($issue->user_id)->not->toBeNull();
        expect($issue->order_id)->not->toBeNull();
        expect($issue->machine_id)->not->toBeNull();
        expect($issue->description)->not->toBeNull();
    });

    it('can create issue with different order types', function (): void {
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();

        livewire(CreateIssue::class)
            ->fillForm([
                'order_number' => 'DELIVERY-'.Str::random(5),
                'order_type' => OrderType::DELIVERY_NOTE,
                'user_id' => $user->id,
                'machine_id' => $machine->id,
                'type' => IssueType::MISSING_ITEMS,
                'priority' => IssuePriority::EXPRESS,
                'status' => IssueStatus::CREATED,
                'description' => 'Delivery note issue',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        $issue = Issue::query()->latest()->first();
        expect($issue->order->type)->toBe(OrderType::DELIVERY_NOTE);
    });

    it('issue notes are created when factory is used', function (): void {
        $issue = Issue::factory()->create();

        expect($issue->notes)->not->toBeEmpty();
        expect($issue->notes->count())->toBeGreaterThanOrEqual(2);
    });

    it('issue belongs to user', function (): void {
        $user = User::factory()->user()->create();
        $machine = Machine::factory()->create();
        $order = Order::factory()->create();

        $issue = Issue::factory()->create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'machine_id' => $machine->id,
        ]);

        expect($issue->user->id)->toBe($user->id);
        expect($issue->user->email)->toBe($user->email);
    });

    it('issue belongs to machine', function (): void {
        $machine = Machine::factory()->create(['name' => 'Test Machine']);
        $issue = Issue::factory()->create(['machine_id' => $machine->id]);

        expect($issue->machine->id)->toBe($machine->id);
        expect($issue->machine->name)->toBe('Test Machine');
    });

    it('issue belongs to order', function (): void {
        $order = Order::factory()->create(['number' => 'ORD-TEST-123']);
        $issue = Issue::factory()->create(['order_id' => $order->id]);

        expect($issue->order->id)->toBe($order->id);
        expect($issue->order->number)->toBe('ORD-TEST-123');
    });

    it('machine has inverse issues relationship', function (): void {
        $machine = Machine::factory()->create();
        $issues = Issue::factory()->count(3)->create(['machine_id' => $machine->id]);

        expect($machine->issues)->toHaveCount(3);
        expect($machine->issues->pluck('id')->toArray())->toContain($issues[0]->id, $issues[1]->id, $issues[2]->id);
    });

    it('order has inverse issues relationship', function (): void {
        $order = Order::factory()->create();
        $issues = Issue::factory()->count(3)->create(['order_id' => $order->id]);

        expect($order->issues)->toHaveCount(3);
        expect($order->issues->pluck('id')->toArray())->toContain($issues[0]->id, $issues[1]->id, $issues[2]->id);
    });
});
