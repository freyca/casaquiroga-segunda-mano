<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class IssuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->sortable()
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('order.number')
                    ->sortable()
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('machine.name')
                    ->limit(20)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->limit(20)
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('priority')
                    ->limit(20)
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->limit(20)
                    ->badge()
                    ->sortable()
                    ->searchable(),
                IconColumn::make('just_arrived')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
