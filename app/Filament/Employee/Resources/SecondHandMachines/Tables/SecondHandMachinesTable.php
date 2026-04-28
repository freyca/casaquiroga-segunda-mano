<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Tables;

use App\Enums\SellStatus;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('identifier_code')
                    ->label(Str::ucfirst(__('identifier_code')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state),
                TextColumn::make('name')
                    ->label(Str::ucfirst(__('name')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->label(Str::ucfirst(__('brand.name')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable(),
                TextColumn::make('model')
                    ->label(Str::ucfirst(__('model')))
                    ->searchable(),
                TextColumn::make('selling_price')
                    ->label(Str::ucfirst(__('selling_price')))
                    ->icon(Heroicon::CurrencyEuro)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sell_status')
                    ->label(Str::ucfirst(__('sell_status')))
                    ->badge()
                    ->searchable(),
            ])
            ->defaultSort('created_at', direction: 'desc')
            ->filters(
                [
                    SelectFilter::make('sell_status')
                        ->label(Str::ucfirst(__('sell_status')))
                        ->multiple()
                        ->options(
                            collect(SellStatus::cases())
                                ->mapWithKeys(fn (SellStatus $case): array => [
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
