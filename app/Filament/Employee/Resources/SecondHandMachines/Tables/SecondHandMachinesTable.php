<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Tables;

use App\Enums\SellStatus;
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
                TextColumn::make('name')
                    ->label(ucfirst(__('name')))
                    ->limit(20)
                    ->tooltip(fn (string $state) => $state)
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->label(ucfirst(__('brand.name')))
                    ->limit(20)
                    ->tooltip(fn (string $state) => $state)
                    ->searchable(),
                TextColumn::make('family.name')
                    ->label(ucfirst(__('family.name')))
                    ->limit(20)
                    ->tooltip(fn (string $state) => $state)
                    ->searchable(),
                TextColumn::make('model')
                    ->label(ucfirst(__('model')))
                    ->searchable(),
                TextColumn::make('selling_price')
                    ->label(ucfirst(__('selling_price')))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax')
                    ->label(ucfirst(__('tax')))
                    ->badge(),
                TextColumn::make('sell_status')
                    ->label(ucfirst(__('sell_status')))
                    ->badge()
                    ->searchable(),
            ])
            ->filters(
                [
                    SelectFilter::make('sell_status')
                        ->label(ucfirst(__('sell_status')))
                        ->options(
                            collect(SellStatus::cases()) // @phpstan-ignore-line
                                ->mapWithKeys(fn (SellStatus $case) => [
                                    $case->value => $case->getLabel(),
                                ])
                                ->toArray()
                        ),

                    SelectFilter::make('tax')
                        ->label(ucfirst(__('tax')))
                        ->options(
                            collect(Tax::cases()) // @phpstan-ignore-line
                                ->mapWithKeys(fn (Tax $case) => [
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
