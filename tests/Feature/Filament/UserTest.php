<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\User;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function mockPanel(string $id): Panel
{
    $panel = test()->getMockBuilder(Panel::class)
        ->disableOriginalConstructor()
        ->getMock();
    $panel->method('getId')->willReturn($id);

    return $panel;
}

describe('UserTest', function (): void {
    it('creates a valid user from the factory', function (): void {
        $user = User::factory()->create();

        expect($user)->toBeInstanceOf(User::class)
            ->and($user->name)->not->toBeEmpty()
            ->and($user->email)->not->toBeEmpty()
            ->and($user->password)->not->toBeEmpty()
            ->and($user->role)->toBeInstanceOf(Role::class);

        expect($user)->toBeInstanceOf(Model::class);
    });

    it('correctly identifies admin and employee roles', function (): void {
        $admin = User::factory()->create(['role' => Role::Admin]);
        $employee = User::factory()->create(['role' => Role::Employee]);
        $user = User::factory()->create(['role' => Role::User]);

        expect($admin->role === Role::Admin)->toBeTrue();
        expect($admin->role === Role::Employee)->toBeFalse();

        expect($employee->role === Role::Employee)->toBeTrue();
        expect($employee->role === Role::Admin)->toBeFalse();

        expect($user->role === Role::Admin)->toBeFalse();
        expect($user->role === Role::Employee)->toBeFalse();
    });

    it('checks panel access for each role', function (): void {
        $admin = User::factory()->create(['role' => Role::Admin]);
        $employee = User::factory()->create(['role' => Role::Employee]);
        $user = User::factory()->create(['role' => Role::User]);

        $adminPanel = mockPanel('admin');
        $employeePanel = mockPanel('employee');
        $otherPanel = mockPanel('other');

        expect($admin->canAccessPanel($adminPanel))->toBeTrue();
        expect($admin->canAccessPanel($employeePanel))->toBeTrue();
        expect($admin->canAccessPanel($otherPanel))->toBeFalse();

        expect($employee->canAccessPanel($employeePanel))->toBeTrue();
        expect($employee->canAccessPanel($adminPanel))->toBeFalse();
        expect($employee->canAccessPanel($otherPanel))->toBeFalse();

        expect($user->canAccessPanel($adminPanel))->toBeFalse();
        expect($user->canAccessPanel($employeePanel))->toBeFalse();
        expect($user->canAccessPanel($otherPanel))->toBeFalse();
    });
});
