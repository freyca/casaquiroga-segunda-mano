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
                Section::make(Str::ucfirst(__('secondhandmachines.general_information')))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('identifier_code')
                            ->label(Str::ucfirst(__('secondhandmachines.identifier_code')))
                            ->copyable(),

                        TextEntry::make('name')
                            ->label(Str::ucfirst(__('app.name'))),
                    ]),

                Section::make(Str::ucfirst(__('app.purchase_info')))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('purchase_cost')
                            ->label(Str::ucfirst(__('app.purchase_cost')))
                            ->money('EUR')
                            ->placeholder('-'),

                        TextEntry::make('customer.name')
                            ->label(Str::ucfirst(__('app.customer')))
                            ->placeholder('-'),

                        TextEntry::make('purchase_notes')
                            ->label(Str::ucfirst(__('app.purchase_notes')))
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('-'),
                    ]),

                Section::make(Str::ucfirst(__('app.machine_details')))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('family.name')
                            ->placeholder('-')
                            ->label(Str::ucfirst(__('app.family'))),

                        TextEntry::make('brand.name')
                            ->placeholder('-')
                            ->label(Str::ucfirst(__('app.brand'))),

                        TextEntry::make('model')
                            ->placeholder('-')
                            ->label(Str::ucfirst(__('app.model'))),

                        TextEntry::make('serial_number')
                            ->copyable()
                            ->placeholder('-')
                            ->label(Str::ucfirst(__('app.serial_number'))),
                    ]),

                Section::make(Str::ucfirst(__('secondhandmachines.sale_information')))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('selling_price')
                            ->money('EUR')
                            ->label(Str::ucfirst(__('app.selling_price')))
                            ->placeholder('-'),

                        TextEntry::make('tax')
                            ->label(Str::ucfirst(__('app.tax')))
                            ->badge(),

                        TextEntry::make('repair_workshop')
                            ->label(Str::ucfirst(__('app.repair_workshop')))
                            ->placeholder('-'),

                        TextEntry::make('sell_status')
                            ->label(Str::ucfirst(__('app.sell_status')))
                            ->badge(),
                    ]),

                Section::make(Str::ucfirst(__('app.extra')))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('work_hours')
                            ->label(Str::ucfirst(__('app.work_hours')))
                            ->suffix(' h')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label(Str::ucfirst(__('app.description')))
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('-'),
                    ]),

                Section::make(Str::ucfirst(__('app.files')))
                    ->schema([
                        ImageEntry::make('photos')
                            ->label(Str::ucfirst(__('app.photos')))
                            ->disk('public')
                            ->visibility('public')
                            ->stacked()
                            ->limit(6)
                            ->placeholder('No photos'),

                        RepeatableEntry::make('attachments')
                            ->label(Str::ucfirst(__('app.attachments')))
                            ->schema([
                                TextEntry::make('file')
                                    ->label('File')
                                    ->formatStateUsing(fn (string $state): string => basename($state)),
                            ]),
                    ]),

                Section::make(Str::ucfirst(__('app.product_notes')))
                    ->schema([
                        RepeatableEntry::make('notes')
                            ->label(Str::ucfirst(__('app.notes')))
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(Str::ucfirst(__('app.created_at')))
                                    ->dateTime('d-m-Y H:i'),

                                TextEntry::make('user.name')
                                    ->label(Str::ucfirst(__('enums.employee'))),

                                TextEntry::make('previous_state')
                                    ->label(Str::ucfirst(__('app.previous_state')))
                                    ->badge(),

                                TextEntry::make('new_state')
                                    ->label(Str::ucfirst(__('app.new_state')))
                                    ->badge(),

                                TextEntry::make('description')
                                    ->label(Str::ucfirst(__('app.description')))
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
