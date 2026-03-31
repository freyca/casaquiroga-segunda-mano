<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Tables;

use App\Enums\Status;
use App\Enums\Tax;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('brand.nombre')
                    ->searchable(),
                TextColumn::make('family.nombre')
                    ->searchable(),
                TextColumn::make('modelo')
                    ->searchable(),
                TextColumn::make('precio_venta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax')
                    ->badge(),
                TextColumn::make('estado')
                    ->badge()
                    ->searchable(),
            ])
            ->filters(
                [
                    SelectFilter::make('estado')
                        ->options(
                            collect(Status::cases()) // @phpstan-ignore-line
                                ->mapWithKeys(fn($case) => [
                                    $case->value => $case->getLabel(),
                                ])
                                ->toArray()
                        ),

                    SelectFilter::make('tax')
                        ->options(
                            collect(Tax::cases()) // @phpstan-ignore-line
                                ->mapWithKeys(fn($case) => [
                                    $case->value => $case->getLabel(),
                                ])
                                ->toArray()
                        ),

                ],
                layout: FiltersLayout::Modal
            )
            ->recordActions([])
            ->toolbarActions([]);
    }
}
