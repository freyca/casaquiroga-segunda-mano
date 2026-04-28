<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\SecondHandMachines\SecondHandMachineResource as AdminSecondHandMachineResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Filament\Employee\Resources\SecondHandMachines\SecondHandMachineResource as EmployeeSecondHandMachineResource;
use Illuminate\Support\Str;

describe('FilamentLabels', function (): void {

    it('employee second hand machine returns correct navigation label', function (): void {
        expect(EmployeeSecondHandMachineResource::getNavigationLabel())
            ->toBe(Str::ucfirst(__('second_hand_machine')));
    });

    it('admin second hand machine returns correct navigation label', function (): void {
        expect(AdminSecondHandMachineResource::getNavigationLabel())
            ->toBe(Str::ucfirst(__('second_hand_machine')));
    });

    it('admin second hand machine returns correct navigation group', function (): void {
        expect(AdminSecondHandMachineResource::getNavigationGroup())
            ->toBe(Str::ucfirst(__('machines_management')));
    });

    it('admin user returns correct navigation group', function (): void {
        expect(UserResource::getNavigationGroup())
            ->toBe(Str::ucfirst(__('user_management')));
    });

    it('admin user returns correct navigation label', function (): void {
        expect(UserResource::getNavigationLabel())
            ->toBe(Str::ucfirst(__('user')));
    });
});
