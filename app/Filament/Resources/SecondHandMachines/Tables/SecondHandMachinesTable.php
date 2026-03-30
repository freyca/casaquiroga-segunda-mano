<?php

declare(strict_types=1);

namespace App\Filament\Resources\SecondHandMachines\Tables;

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
                TextColumn::make('responsableCompra.name')
                    ->searchable(),
                TextColumn::make('clienteCompra.name')
                    ->searchable(),
                TextColumn::make('familia.id')
                    ->searchable(),
                TextColumn::make('marca.id')
                    ->searchable(),
                TextColumn::make('modelo')
                    ->searchable(),
                TextColumn::make('numero_serie')
                    ->searchable(),
                TextColumn::make('precio_venta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('taller_reparacion')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax')
                    ->badge()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('horas_trabajo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
