<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Tables;

use App\Enums\SellStatus;
use App\Enums\Tax;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('identifier_code')
                    ->label(ucfirst(__('identifier_code')))
                    ->limit(20)
                    ->tooltip(fn(string $state): string => $state),
                TextColumn::make('name')
                    ->label(ucfirst(__('name')))
                    ->limit(20)
                    ->tooltip(fn(string $state): string => $state)
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->label(ucfirst(__('brand.name')))
                    ->limit(20)
                    ->tooltip(fn(string $state): string => $state)
                    ->searchable(),
                TextColumn::make('model')
                    ->label(ucfirst(__('model')))
                    ->searchable(),
                TextColumn::make('selling_price')
                    ->label(ucfirst(__('selling_price')))
                    ->icon(Heroicon::CurrencyEuro)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sell_status')
                    ->label(ucfirst(__('sell_status')))
                    ->badge()
                    ->searchable(),
            ])
            ->defaultSort('created_at', direction: 'asc')
            ->filters(
                [
                    SelectFilter::make('sell_status')
                        ->label(ucfirst(__('sell_status')))
                        ->options(
                            collect(SellStatus::cases())
                                ->mapWithKeys(fn(SellStatus $case): array => [
                                    $case->value => $case->getLabel(),
                                ])
                                ->all()
                        ),

                    SelectFilter::make('tax')
                        ->label(ucfirst(__('tax')))
                        ->options(
                            collect(Tax::cases())
                                ->mapWithKeys(fn(Tax $case): array => [
                                    $case->value => $case->getLabel(),
                                ])
                                ->all()
                        ),

                ],
                layout: FiltersLayout::Modal
            )
            ->recordActions([])
            ->toolbarActions([]);
    }
}
