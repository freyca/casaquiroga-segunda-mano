<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\Family;
use App\Models\Issue;
use App\Models\Machine;
use App\Models\Note;
use App\Models\Order;
use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

describe('DatabaseSeeder', function (): void {
    it('seeds the database without errors', function (): void {
        $this->seed();

        // Issues and related models
        expect(Issue::query()->count())->toBeGreaterThan(0);
        expect(Machine::query()->count())->toBeGreaterThan(0);
        expect(Order::query()->count())->toBeGreaterThan(0);

        // Second hand machines
        expect(SecondHandMachine::query()->count())->toBeGreaterThan(0);
        expect(Brand::query()->count())->toBeGreaterThan(0);
        expect(Family::query()->count())->toBeGreaterThan(0);

        // Users
        expect(User::query()->count())->toBeGreaterThan(0);

        // Notes
        expect(Note::query()->count())->toBeGreaterThan(0);
    });
});
