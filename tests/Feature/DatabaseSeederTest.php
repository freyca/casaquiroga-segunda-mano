<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\Family;
use App\Models\Issue;
use App\Models\IssueNote;
use App\Models\Machine;
use App\Models\Order;
use App\Models\SecondHandMachine;
use App\Models\SecondHandMachineNote;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

describe('DatabaseSeeder', function (): void {
    it('seeds the database without errors', function (): void {
        $this->seed();

        // Issues, its notes and related models
        expect(IssueNote::query()->count())->toBeGreaterThan(0);
        expect(Issue::query()->count())->toBeGreaterThan(0);
        expect(Machine::query()->count())->toBeGreaterThan(0);
        expect(Order::query()->count())->toBeGreaterThan(0);

        // Second hand machines and its notes
        expect(SecondHandMachineNote::query()->count())->toBeGreaterThan(0);
        expect(SecondHandMachine::query()->count())->toBeGreaterThan(0);
        expect(Brand::query()->count())->toBeGreaterThan(0);
        expect(Family::query()->count())->toBeGreaterThan(0);

        // Users
        expect(User::query()->count())->toBeGreaterThan(0);
    });
});
