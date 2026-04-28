<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Brands\BrandResource;
use App\Filament\Admin\Resources\Families\FamilyResource;
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

    it('admin brand returns correct navigation label', function (): void {
        expect(BrandResource::getNavigationLabel())
            ->toBe(Str::ucfirst(__('brand')));
    });

    it('admin brand returns correct navigation group', function (): void {
        expect(BrandResource::getNavigationGroup())
            ->toBe(Str::ucfirst(__('machines_management')));
    });

    it('admin family returns correct navigation group', function (): void {
        expect(FamilyResource::getNavigationGroup())
            ->toBe(Str::ucfirst(__('machines_management')));
    });

    it('admin family returns correct navigation label', function (): void {
        expect(FamilyResource::getNavigationLabel())
            ->toBe(Str::ucfirst(__('family')));
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
