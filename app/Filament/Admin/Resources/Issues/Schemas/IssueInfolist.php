<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class IssueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic information')
                    ->schema([
                        TextEntry::make('user.email')
                            ->label('User email')
                            ->icon(Heroicon::User),

                        TextEntry::make('order.number')
                            ->icon(Heroicon::ReceiptPercent)
                            ->label('Order'),

                        TextEntry::make('machine.name')
                            ->label('Machine')
                            ->icon(Heroicon::Cog8Tooth),
                    ])
                    ->columns(2),

                Section::make('Issue details')
                    ->schema([
                        IconEntry::make('just_arrived')
                            ->boolean()
                            ->label('Just arrived'),

                        TextEntry::make('type')
                            ->badge(),

                        TextEntry::make('priority')
                            ->badge(),

                        TextEntry::make('status')
                            ->badge(),
                    ])
                    ->columns(2),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->collapsible(),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(Str::ucfirst(__('created at')))
                            ->dateTime('d/m/Y H:i')
                            ->icon(Heroicon::Clock)
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label(Str::ucfirst(__('updated at')))
                            ->dateTime('d/m/Y H:i')
                            ->icon(Heroicon::ArrowPath)
                            ->placeholder('-'),
                    ])
                    ->collapsible()
                    ->columns(2),

                Section::make('Additional info')
                    ->columnSpanFull()
                    ->schema([

                        TextEntry::make('observations')
                            ->placeholder('-'),

                        ImageEntry::make('images')
                            ->placeholder('-'),
                    ])
                    ->collapsible(),
            ]);
    }
}
