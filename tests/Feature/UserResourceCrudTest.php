<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Models\User;
use App\Enums\Role;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Pest\Livewire\livewire;

uses(LazilyRefreshDatabase::class);

describe('UserResource', function () {
    it('can load the users list page and display records', function () {
        $users = User::factory()->count(3)->create();

        livewire(ListUsers::class)
            ->assertOk()
            ->assertCanSeeTableRecords($users);
    });

    it('can create a user', function () {
        $email = 'testuser' . Str::random(5) . '@example.com';
        livewire(CreateUser::class)
            ->fillForm([
                'name' => 'Test User',
                'email' => $email,
                'role' => Role::User,
                'password' => 'password',
            ])
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(User::where('email', $email)->exists())->toBeTrue();
    });

    it('can edit a user with all fields', function () {
        $user = User::factory()->create(['name' => 'Old Name']);

        livewire(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'name' => 'New Name',
                'email' => $user->email,
                'role' => $user->role,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($user->refresh()->name)->toBe('New Name');
    });

    it('can change user password', function () {
        $user = User::factory()->create();

        livewire(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'password' => 'password',
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect(Hash::check('password', $user->refresh()->password))->toBeTrue();
    });

    it('can edit a user without changing password', function () {
        $user = User::factory()->employee()->create();

        expect($user->refresh()->role)->toBe(Role::Employee);

        livewire(EditUser::class, ['record' => $user->id])
            ->fillForm([
                'role' => Role::Admin,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertNotified();

        expect($user->refresh()->role)->toBe(Role::Admin);
    });
});
