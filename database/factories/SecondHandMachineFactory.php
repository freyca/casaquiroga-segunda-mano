<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Role;
use App\Enums\SellStatus;
use App\Enums\Tax;
use App\Models\Brand;
use App\Models\Family;
use App\Models\Notes;
use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SecondHandMachine>
 */
class SecondHandMachineFactory extends Factory
{
    protected $model = SecondHandMachine::class;

    public function definition(): array
    {
        return [
            'identifier_code' => strtoupper($this->faker->bothify('MAQ-####??')),
            'name' => $this->faker->words(3, true),
            'purchase_cost' => $this->faker->randomFloat(2, 500, 50000),
            'employee_id' => function () {
                return User::query()
                    ->where('role', Role::Employee)
                    ->inRandomOrder()
                    ->value('id')
                    ?? User::factory()->employee()->create()->id;
            },
            'customer_id' => function () {
                return User::query()
                    ->where('role', Role::User)
                    ->inRandomOrder()
                    ->value('id')
                    ?? User::factory()->user()->create()->id;
            },
            'purchase_notes' => $this->faker->optional()->sentence(),
            'family_id' => Family::query()
                ->inRandomOrder()
                ->value('id')
                ?? Family::factory()->create()->id,
            'brand_id' => Brand::query()
                ->inRandomOrder()
                ->value('id')
                ?? Brand::factory()->create()->id,
            'model' => strtoupper($this->faker->bothify('MOD-??##')),
            'serial_number' => strtoupper($this->faker->unique()->bothify('SN-????####')),
            'repair_workshop' => $this->faker->randomFloat(2, 1000, 80000),
            'selling_price' => $this->faker->randomFloat(2, 1000, 80000),
            'tax' => $this->faker->randomElement(Tax::cases()),
            'work_hours' => $this->faker->numberBetween(0, 10000),
            'description' => $this->faker->optional()->paragraph(),
            'sell_status' => $this->faker->randomElement(SellStatus::cases()),
            'photos' => null,
            'attachments' => null,
        ];
    }

    public function sinImpuesto(): static
    {
        return $this->state(fn() => [
            'tax' => Tax::Zero,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (SecondHandMachine $machine) {

            $users = User::query()
                ->where('role', Role::Employee)
                ->inRandomOrder()
                ->take(2)
                ->pluck('id');

            // If not enough users exist, create them
            while ($users->count() < 2) {
                $users->push(
                    User::factory()->employee()->create()->id
                );
            }

            foreach ($users as $userId) {
                Notes::factory()->create([
                    'second_hand_machine_id' => $machine->id,
                    'user_id' => $userId,
                ]);
            }
        });
    }
}
