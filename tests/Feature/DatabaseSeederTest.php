<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\Family;
use App\Models\SecondHandMachine;
use App\Models\SecondHandMachineNotes;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

describe('DatabaseSeeder', function (): void {
    it('seeds the database without errors', function (): void {
        $this->seed();

        expect(User::query()->count())->toBeGreaterThan(0);
        expect(SecondHandMachine::query()->count())->toBeGreaterThan(0);
        expect(SecondHandMachineNotes::query()->count())->toBeGreaterThan(0);
        expect(Brand::query()->count())->toBeGreaterThan(0);
        expect(Family::query()->count())->toBeGreaterThan(0);
    });
});
