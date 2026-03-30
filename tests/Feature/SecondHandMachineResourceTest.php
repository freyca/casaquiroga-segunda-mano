<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\SecondHandMachines\Pages\ListSecondHandMachines;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\CreateSecondHandMachine;
use App\Filament\Admin\Resources\SecondHandMachines\Pages\EditSecondHandMachine;
use App\Models\SecondHandMachine;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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

        expect(SecondHandMachine::where('codigo', $data['codigo'])->exists())->toBeFalse();

        livewire(CreateSecondHandMachine::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(SecondHandMachine::where('codigo', $data['codigo'])->exists())->toBeTrue();
    });

    it('can edit a second hand machine', function () {
        $machine = SecondHandMachine::factory()->create(['nombre' => 'Old Name']);

        livewire(EditSecondHandMachine::class, ['record' => $machine->id])
            ->fillForm([
                'nombre' => 'New Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($machine->refresh()->nombre)->toBe('New Name');
    });
});
