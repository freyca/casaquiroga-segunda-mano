<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\SecondHandMachines\Pages\CreateSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\EditSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\ListSecondHandMachines;
use App\Models\SecondHandMachine;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('SecondHandMachineResource', function () {
    it('can list second hand machines', function () {
        $machines = SecondHandMachine::factory()->count(3)->create();

        livewire(ListSecondHandMachines::class)
            ->assertOk()
            ->assertCanSeeTableRecords($machines);
    });

    it('can create a second hand machine', function () {
        $data = SecondHandMachine::factory()->make()->toArray();

        unset($data['id'], $data['created_at'], $data['updated_at']);

        expect(SecondHandMachine::where('identifier_code', $data['identifier_code'])->exists())->toBeFalse();

        livewire(CreateSecondHandMachine::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(SecondHandMachine::where('identifier_code', $data['identifier_code'])->exists())->toBeTrue();
    });

    it('can edit a second hand machine', function () {
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

    it('can upload photos and attachments', function () {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('photo.jpg');
        $pdf = UploadedFile::fake()->create('manual.pdf', 100, 'application/pdf');

        $data = SecondHandMachine::factory()->make()->toArray();
        unset($data['id'], $data['created_at'], $data['updated_at']);
        $data['photos'] = [$photo];
        $data['attachments'] = [$pdf];

        livewire(CreateSecondHandMachine::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        $machine = SecondHandMachine::latest()->first();
        expect($machine->photos)->not->toBeEmpty();
        expect($machine->attachments)->not->toBeEmpty();
        Storage::disk('public')->assertExists($machine->photos[0]);
        Storage::disk('public')->assertExists($machine->attachments[0]);
    });
});
