<?php

declare(strict_types=1);

use App\Models\SecondHandMachine;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

describe('SecondHandMachinePrintController', function (): void {
    it('route is not accessible without authentication', function (): void {
        $machine = SecondHandMachine::factory()->create();

        $response = $this->get(route('secondhandmachines.print', $machine));
        $response->assertRedirect(route('login'));
    });

    it('route is accessible for logged in users', function (): void {
        $machine = SecondHandMachine::factory()->create();

        $this->actingAs(User::factory()->admin()->create());
        $response = $this->get(route('secondhandmachines.print', $machine));
        $response->assertOk();

        $this->actingAs(User::factory()->employee()->create());
        $response = $this->get(route('secondhandmachines.print', $machine));
        $response->assertOk();

        $this->actingAs(User::factory()->user()->create());
        $response = $this->get(route('secondhandmachines.print', $machine));
        $response->assertOk();
    });

    it('displays machine and default fields', function (): void {
        $this->actingAs(User::factory()->admin()->create());
        $machine = SecondHandMachine::factory()->create();

        $response = $this->get(route('secondhandmachines.print', $machine));

        $response->assertOk();
        $response->assertViewIs('secondhandmachines.print');
        $response->assertViewHas('machine', $machine);
        $response->assertViewHas('show_fields');

        $fields = $response->viewData('show_fields');

        expect($fields)->toContain('photos')
            ->toContain('brand')
            ->toContain('model')
            ->toContain('identifier_code')
            ->not->toContain('work_hours')
            ->toContain('selling_price')
            ->toContain('description')
            ->not->toContain('sell_status');
    });

    it('respects show_fields query param', function (): void {
        $this->actingAs(User::factory()->admin()->create());
        $machine = SecondHandMachine::factory()->create();
        $show_fields = ['brand', 'model'];
        $dont_show_fields = ['photos', 'identifier_code', 'work_hours', 'selling_price', 'description', 'sell_status'];

        $response = $this->get(route('secondhandmachines.print', [
            $machine,
            'show_fields' => implode(',', $show_fields),
        ]));

        $response->assertOk();
        $response->assertViewHas('show_fields', $show_fields);

        expect($response->viewData('show_fields'))
            ->toBe($show_fields)
            ->not->toContain($dont_show_fields);
    });
});
