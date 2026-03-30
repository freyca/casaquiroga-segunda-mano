<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SecondHandMachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('marca.nombre')
                    ->searchable(),
                TextColumn::make('familia.nombre')
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
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
