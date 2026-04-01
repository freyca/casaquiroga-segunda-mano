<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Brands\Pages\CreateBrand;
use App\Filament\Admin\Resources\Brands\Pages\EditBrand;
use App\Filament\Admin\Resources\Brands\Pages\ListBrands;
use App\Models\Brand;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('BrandResource', function (): void {
    it('can load the Brands list page and display records', function (): void {
        $Brands = Brand::factory()->count(3)->create();

        livewire(ListBrands::class)
            ->assertOk()
            ->assertCanSeeTableRecords($Brands);
    });

    it('can create a Brand', function (): void {
        livewire(CreateBrand::class)
            ->fillForm([
                'name' => 'Test Brand',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(Brand::query()->where('name', 'Test Brand')->exists())->toBeTrue();
    });

    it('can edit a Brand', function (): void {
        $Brand = Brand::factory()->create(['name' => 'Old Name']);

        livewire(EditBrand::class, ['record' => $Brand->id])
            ->fillForm([
                'name' => 'New Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($Brand->refresh()->name)->toBe('New Name');
    });
});
