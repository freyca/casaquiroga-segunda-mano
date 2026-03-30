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
                TextColumn::make('codigo')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('coste')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('familia.id')
                    ->searchable(),
                TextColumn::make('marca.id')
                    ->searchable(),
                TextColumn::make('precio_venta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax')
                    ->badge(),
                TextColumn::make('horas_trabajo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado')
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
