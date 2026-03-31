<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Brand;
use App\Models\Family;
use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(['email' => 'fran@gmail.com'], [
            'name' => 'Admin User',
            'password' => bcrypt('fran@gmail.com'),
            'role' => Role::Admin,
        ]);

        User::factory(5)->employee()->create();

        User::factory(5)->user()->create();

        Family::factory(5)->create();

        Brand::factory(5)->create();

        SecondHandMachine::factory(10)->create();
    }
}
