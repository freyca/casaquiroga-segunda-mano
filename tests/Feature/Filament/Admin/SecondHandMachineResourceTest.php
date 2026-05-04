<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Enums\SellStatus;
use App\Enums\Tax;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\CreateSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\EditSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\ListSecondHandMachines;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\ViewSecondHandMachine;
use App\Models\Brand;
use App\Models\Family;
use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('SecondHandMachineResource', function (): void {
    it('can list second hand machines', function (): void {
        $machines = SecondHandMachine::factory()->count(3)->create();

        livewire(ListSecondHandMachines::class)
            ->assertOk()
            ->assertCanSeeTableRecords($machines);
    });

    it('can display correct table columns', function (): void {
        $machine = SecondHandMachine::factory()->create();

        livewire(ListSecondHandMachines::class)
            ->assertCanSeeTableRecords([$machine]);
    });

    it('can sort table columns', function (): void {
        SecondHandMachine::factory()->count(3)->create();

        livewire(ListSecondHandMachines::class)
            ->sortTable('purchase_cost')
            ->assertCanSeeTableRecords(SecondHandMachine::query()->orderBy('purchase_cost')->get())
            ->sortTable('purchase_cost', 'desc')
            ->assertCanSeeTableRecords(SecondHandMachine::query()->orderByDesc('purchase_cost')->get());
    });

    it('can search in table', function (): void {
        $machine = SecondHandMachine::factory()->create(['name' => 'Unique Machine Name']);

        livewire(ListSecondHandMachines::class)
            ->searchTable('Unique Machine Name')
            ->assertCanSeeTableRecords([$machine])
            ->searchTable('Non-existent')
            ->assertCanNotSeeTableRecords([$machine]);
    });

    it('can create a second hand machine', function (): void {
        $family = Family::factory()->create();
        $brand = Brand::factory()->create();
        $seller = User::factory()->create(['role' => Role::Employee]);

        livewire(CreateSecondHandMachine::class)
            ->fillForm([
                'name' => 'Test Machine',
                'identifier_code' => 'TEST-001',
                'family_id' => $family->id,
                'brand_id' => $brand->id,
                'purchase_cost' => 1000.50,
                'sell_status' => SellStatus::Available->value,
                'tax' => Tax::TwentyOne->value,
                'employee_id' => $seller->id,
                'description' => 'Test description',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(SecondHandMachine::query()->where('identifier_code', 'TEST-001')->exists())->toBeTrue();
    });

    it('validates required fields when creating', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->fillForm([
                'name' => null,
                'identifier_code' => null,
                'sell_status' => null,
                'tax' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'identifier_code' => 'required',
                'sell_status' => 'required',
                'tax' => 'required',
            ])
            ->assertNotNotified();
    });

    it('validates numeric fields', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->fillForm([
                'purchase_cost' => 'not-a-number',
                'selling_price' => 'not-a-number',
                'work_hours' => 'not-a-number',
            ])
            ->call('create')
            ->assertHasFormErrors([
                'purchase_cost' => 'numeric',
                'selling_price' => 'numeric',
                'work_hours' => 'numeric',
            ]);
    });

    it('can create a family from inline form', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->callFormComponentAction('family_id', 'createOption', data: [
                'name' => 'New Family',
            ]);

        expect(Family::query()->where('name', 'New Family')->exists())->toBeTrue();
    });

    it('can create a brand from inline form', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->callFormComponentAction('brand_id', 'createOption', data: [
                'name' => 'New Brand',
            ]);

        expect(Brand::query()->where('name', 'New Brand')->exists())->toBeTrue();
    });

    it('can create a customer from inline form', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->callFormComponentAction('customer_id', 'createOption', data: [
                'name' => 'New Customer',
                'email' => 'customer@example.com',
                'phone' => '123456789',
            ]);

        expect(User::query()->where('email', 'customer@example.com')->exists())->toBeTrue();
    });

    it('validates family inline create form', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->callFormComponentAction('family_id', 'createOption', data: [
                'name' => null,
            ])
            ->assertHasFormErrors(['name' => 'required']);
    });

    it('validates brand inline create form', function (): void {
        livewire(CreateSecondHandMachine::class)
            ->callFormComponentAction('brand_id', 'createOption', data: [
                'name' => null,
            ])
            ->assertHasFormErrors(['name' => 'required']);
    });

    it('can edit a second hand machine', function (): void {
        $machine = SecondHandMachine::factory()->create(['name' => 'Old Name']);

        livewire(EditSecondHandMachine::class, ['record' => $machine->id])
            ->fillForm([
                'name' => 'New Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($machine->refresh()->name)->toBe('New Name');
    });

    it('can edit sell status', function (): void {
        $machine = SecondHandMachine::factory()->create(['sell_status' => SellStatus::Available]);

        livewire(EditSecondHandMachine::class, ['record' => $machine->id])
            ->fillForm([
                'sell_status' => SellStatus::Sold->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($machine->refresh()->sell_status)->toBe(SellStatus::Sold);
    });

    it('can view a second hand machine', function (): void {
        $machine = SecondHandMachine::factory()->create();

        livewire(ViewSecondHandMachine::class, ['record' => $machine->id])
            ->assertOk();
    });

    it('can delete a second hand machine', function (): void {
        $machine = SecondHandMachine::factory()->create();

        livewire(EditSecondHandMachine::class, ['record' => $machine->id])
            ->callAction('delete')
            ->assertNotified()
            ->assertRedirect();

        expect(SecondHandMachine::query()->where('id', $machine->id)->exists())->toBeFalse();
    });

    it('can upload photos and attachments', function (): void {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('photo.jpg');
        $pdf = UploadedFile::fake()->create('manual.pdf', 100, 'application/pdf');

        livewire(CreateSecondHandMachine::class)
            ->fillForm([
                'name' => 'Test Machine',
                'identifier_code' => 'TEST-002',
                'photos' => [$photo],
                'attachments' => [$pdf],
                'sell_status' => SellStatus::Available->value,
                'tax' => Tax::TwentyOne->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        $machine = SecondHandMachine::query()->latest()->first();
        expect($machine->photos)->not->toBeEmpty();
        expect($machine->attachments)->not->toBeEmpty();
    });
});
