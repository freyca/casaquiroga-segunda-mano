<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->limit(20)
                    ->tooltip(fn($state) => $state)
                    ->searchable(),

                TextColumn::make('coste')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('selling_price')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('family.name')
                    ->label('Familia')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->label('Marca')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tax')
                    ->label('IVA')
                    ->badge(),

                TextColumn::make('sell_status')
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
