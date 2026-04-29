<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class IssuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')
                    ->label(Str::ucfirst(__('app.customer')))
                    ->sortable()
                    ->limit(25)
                    ->searchable(),
                TextColumn::make('order.number')
                    ->label(Str::ucfirst(__('app.order')))
                    ->sortable()
                    ->limit(12)
                    ->searchable(),
                TextColumn::make('machine.name')
                    ->label(Str::ucfirst(__('app.machine')))
                    ->limit(25)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label(Str::ucfirst(__('issues.issue_type_short')))
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('priority')
                    ->label(Str::ucfirst(__('issues.issue_priority_short')))
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label(Str::ucfirst(__('issues.issue_status_short')))
                    ->badge()
                    ->sortable()
                    ->searchable(),
                IconColumn::make('just_arrived')
                    ->label(Str::ucfirst(__('issues.just_arrived_short')))
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ]);
    }
}
