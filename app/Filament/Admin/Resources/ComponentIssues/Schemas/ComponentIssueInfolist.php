<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class ComponentIssueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('reference_number')
                    ->label(Str::ucfirst(__('app.reference_number')))
                    ->size('lg')
                    ->weight('bold')
                    ->copyable()
                    ->columnSpanFull(),

                Section::make(Str::ucfirst(__('app.basic_information')))
                    ->schema([
                        TextEntry::make('customer.email')
                            ->label(Str::ucfirst(__('issues.user_email')))
                            ->icon(Heroicon::User),

                        TextEntry::make('machine.name')
                            ->label(Str::ucfirst(__('issues.machine')))
                            ->icon(Heroicon::Cog8Tooth),
                    ])
                    ->columns(2),

                Section::make(Str::ucfirst(__('app.issue_details')))
                    ->schema([
                        IconEntry::make('just_arrived')
                            ->boolean()
                            ->label(Str::ucfirst(__('issues.just_arrived'))),

                        TextEntry::make('priority')
                            ->label(Str::ucfirst(__('issues.issue_priority')))
                            ->badge(),

                        TextEntry::make('status')
                            ->label(Str::ucfirst(__('issues.issue_status')))
                            ->badge(),
                    ])
                    ->columns(2),

                Section::make(Str::ucfirst(__('app.description')))
                    ->schema([
                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->collapsible(),

                Section::make(Str::ucfirst(__('app.timestamps')))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(Str::ucfirst(__('app.created_at')))
                            ->dateTime('d/m/Y H:i')
                            ->icon(Heroicon::Clock)
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label(Str::ucfirst(__('app.updated_at')))
                            ->dateTime('d/m/Y H:i')
                            ->icon(Heroicon::ArrowPath)
                            ->placeholder('-'),
                    ])
                    ->collapsible()
                    ->columns(2),

                Section::make(Str::ucfirst(__('app.additional_info')))
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('author.name')
                            ->label(Str::ucfirst(__('app.created_by')))
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label(Str::ucfirst(__('issues.description')))
                            ->placeholder('-'),

                        ImageEntry::make('images')
                            ->label(Str::ucfirst(__('app.photos')))
                            ->placeholder('-'),
                    ])
                    ->collapsible(),

                Section::make(Str::ucfirst(__('issues.issue_notes')))
                    ->schema([
                        RepeatableEntry::make('notes')
                            ->label(Str::ucfirst(__('app.notes')))
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(Str::ucfirst(__('app.created_at')))
                                    ->dateTime('d-m-Y H:i'),

                                TextEntry::make('user.name')
                                    ->label(Str::ucfirst(__('app.user'))),

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
