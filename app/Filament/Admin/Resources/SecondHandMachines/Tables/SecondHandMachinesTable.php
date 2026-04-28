<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(Str::ucfirst(__('name')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable(),

                TextColumn::make('purchase_cost')
                    ->label(Str::ucfirst(__('purchase_cost')))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('selling_price')
                    ->label(Str::ucfirst(__('selling_price')))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('family.name')
                    ->label(Str::ucfirst(__('family')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->label(Str::ucfirst(__('brand')))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => $state)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tax')
                    ->label(Str::ucfirst(__('tax')))
                    ->badge(),

                TextColumn::make('sell_status')
                    ->label(Str::ucfirst(__('sell_status')))
                    ->sortable()
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
