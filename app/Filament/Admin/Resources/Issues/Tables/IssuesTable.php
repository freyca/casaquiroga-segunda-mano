<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Tables;

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
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('order.number')
                    ->sortable()
                    ->limit(12)
                    ->searchable(),
                TextColumn::make('machine.name')
                    ->limit(25)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('priority')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                IconColumn::make('just_arrived')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ]);
    }
}
