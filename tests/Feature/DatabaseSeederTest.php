<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Family;
use App\Models\Brand;
use App\Models\SecondHandMachine;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

describe('DatabaseSeeder', function () {
    it('seeds the database with expected records', function () {
        $this->seed();

        // Assert the expected number of records
        expect(SecondHandMachine::count())->toBe(10);
        expect(Family::count())->toBe(13); // 3 + 10 SecondHandMachine creates a family per each
        expect(Brand::count())->toBe(13); // 3 + 10 SecondHandMachine creates a brand per each
        expect(User::count())->toBe(30); // 10 + 10*2 SecondHandMachine creates a user and an employee per each

    });
});
