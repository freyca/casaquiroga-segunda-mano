<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Enums\Tax;
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
            'codigo'                => strtoupper($this->faker->bothify('MAQ-####??')),
            'nombre'                => $this->faker->words(3, true),
            'coste'                 => $this->faker->randomFloat(2, 500, 50000),
            'responsable_compra_id' => User::factory(),
            'cliente_compra_id'     => User::factory(),
            'observaciones_compra'  => $this->faker->optional()->sentence(),
            'familia_id'            => null, // set when Familia factory exists
            'marca'                 => $this->faker->company(),
            'modelo'                => strtoupper($this->faker->bothify('MOD-??##')),
            'numero_serie'          => strtoupper($this->faker->unique()->bothify('SN-????####')),
            'taller_reparacion_id'  => null, // set when TallerReparacion factory exists
            'precio_venta'          => $this->faker->randomFloat(2, 1000, 80000),
            'tax'                   => $this->faker->randomElement(Tax::cases()),
            'horas_trabajo'         => $this->faker->numberBetween(0, 10000),
            'descripcion'           => $this->faker->optional()->paragraph(),
            'estado'                => $this->faker->randomElement(Status::cases()),
            'fotos'                 => null,
            'adjuntos'              => null,
        ];
    }

    public function disponible(): static
    {
        return $this->state(fn(array $attributes) => [
            'estado' => Status::Disponible,
        ]);
    }

    public function vendida(): static
    {
        return $this->state(fn(array $attributes) => [
            'estado' => Status::Vendida,
        ]);
    }

    public function sinImpuesto(): static
    {
        return $this->state(fn(array $attributes) => [
            'tax' => Tax::Zero,
        ]);
    }
}
