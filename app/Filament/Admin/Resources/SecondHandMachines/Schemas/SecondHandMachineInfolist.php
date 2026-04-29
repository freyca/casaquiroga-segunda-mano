<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class SecondHandMachineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('identifier_code')
                            ->copyable(),

                        TextEntry::make('name'),
                    ]),

                Section::make('Purchase Info')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('purchase_cost')
                            ->money('EUR')
                            ->placeholder('-'),

                        TextEntry::make('customer.name')
                            ->label('Customer')
                            ->placeholder('-'),

                        TextEntry::make('purchase_notes')
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('-'),
                    ]),

                Section::make('Machine Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('family.name')->placeholder('-'),
                        TextEntry::make('brand.name')->placeholder('-'),

                        TextEntry::make('model')->placeholder('-'),

                        TextEntry::make('serial_number')
                            ->copyable()
                            ->placeholder('-'),
                    ]),

                Section::make('Sale Info')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('selling_price')
                            ->money('EUR')
                            ->placeholder('-'),

                        TextEntry::make('tax')
                            ->badge(),

                        TextEntry::make('repair_workshop')
                            ->placeholder('-'),

                        TextEntry::make('sell_status')
                            ->badge(),
                    ]),

                Section::make('Extra')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('work_hours')
                            ->suffix(' h')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('-'),
                    ]),

                Section::make('Files')
                    ->schema([
                        ImageEntry::make('photos')
                            ->disk('public')
                            ->visibility('public')
                            ->stacked()
                            ->limit(6)
                            ->placeholder('No photos'),

                        RepeatableEntry::make('attachments')
                            ->schema([
                                TextEntry::make('file')
                                    ->label('File')
                                    ->formatStateUsing(fn (string $state): string => basename($state)),
                            ]),
                    ]),

                Section::make(Str::ucfirst(__('product_notes')))
                    ->schema([
                        RepeatableEntry::make('notes')
                            ->label(Str::ucfirst(__('notes')))
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(Str::ucfirst(__('created at')))
                                    ->dateTime('d-m-Y H:i'),

                                TextEntry::make('user.name')
                                    ->label(Str::ucfirst(__('user'))),

                                TextEntry::make('previous_state')
                                    ->label(Str::ucfirst(__('previous state')))
                                    ->badge(),

                                TextEntry::make('new_state')
                                    ->label(Str::ucfirst(__('new state')))
                                    ->badge(),

                                TextEntry::make('description')
                                    ->label(Str::ucfirst(__('description')))
                                    ->columnSpanFull()
                                    ->markdown(),
                            ])
                            ->columns(4),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
