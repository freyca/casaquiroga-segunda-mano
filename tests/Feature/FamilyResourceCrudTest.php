<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Families\Pages\CreateFamily;
use App\Filament\Admin\Resources\Families\Pages\EditFamily;
use App\Filament\Admin\Resources\Families\Pages\ListFamilies;
use App\Models\Family;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('FamilyResource', function () {
    it('can load the families list page and display records', function () {
        $families = Family::factory()->count(3)->create();

        livewire(ListFamilies::class)
            ->assertOk()
            ->assertCanSeeTableRecords($families);
    });


    it('can create a family', function () {
        livewire(CreateFamily::class)
            ->fillForm([
                'nombre' => 'Test Family',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(Family::where('nombre', 'Test Family')->exists())->toBeTrue();
    });

    it('can edit a family', function () {
        $family = Family::factory()->create(['nombre' => 'Old Name']);

        livewire(EditFamily::class, ['record' => $family->id])
            ->fillForm([
                'nombre' => 'New Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($family->refresh()->nombre)->toBe('New Name');
    });
});
