<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Issues\Schemas;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Enums\OrderType;
use App\Filament\Admin\Resources\Machines\Schemas\MachineForm;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Models\Issue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class IssueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_number')
                    ->label(Str::ucfirst(__('app.reference_number')))
                    ->disabled()
                    ->columnSpanFull()
                    ->copyable()
                    ->hiddenOn('create'),

                Section::make(Str::ucfirst(__('app.order')))
                    ->schema([
                        Hidden::make('order_id'),

                        TextInput::make('order_number')
                            ->label(Str::ucfirst(__('app.order_number')))
                            ->required()
                            ->disabled(fn (string $context): bool => $context !== 'create')
                            ->afterStateHydrated(function (Set $set, ?Issue $record): void {
                                if (! $record instanceof Issue || ! $record->relationLoaded('order')) {
                                    return;
                                }

                                $set('order_number', $record->order?->number);
                            }),

                        ToggleButtons::make('order_type')
                            ->label(Str::ucfirst(__('enums.order_type')))
                            ->options(OrderType::class)
                            ->inline()
                            ->required()
                            ->afterStateHydrated(function (Set $set, ?Issue $record): void {
                                if (! $record instanceof Issue || ! $record->relationLoaded('order')) {
                                    return;
                                }

                                $set('order_type', $record->order?->type);
                            }),
                    ])
                    ->collapsible(),

                Section::make(Str::ucfirst(__('issues.customer_data')))
                    ->collapsible()
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'phone')
                            ->label(Str::ucfirst(__('app.customer')))
                            ->required()
                            ->prefixIcon(Heroicon::User)
                            ->searchable()
                            ->createOptionForm(
                                UserForm::partialConfigure(
                                    Schema::make()
                                )->getComponents()
                            ),
                    ]),

                Section::make(Str::ucfirst(__('app.machine')))
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        Select::make('machine_id')
                            ->relationship('machine', 'name')
                            ->label(Str::ucfirst(__('app.machine')))
                            ->prefixIcon(Heroicon::Cog8Tooth)
                            ->required()
                            ->searchable()
                            ->createOptionForm(
                                MachineForm::configure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        Grid::make()
                            ->columns(2)
                            ->schema([
                                Toggle::make('just_arrived')
                                    ->label(Str::ucfirst(__('issues.just_arrived')))
                                    ->inline(false),

                                ToggleButtons::make('priority')
                                    ->label(Str::ucfirst(__('issues.issue_priority')))
                                    ->inline()
                                    ->default(IssuePriority::STANDARD)
                                    ->options(IssuePriority::class)
                                    ->required(),
                            ]),

                        ToggleButtons::make('status')
                            ->label(Str::ucfirst(__('issues.issue_status')))
                            ->inline()
                            ->default(IssueStatus::CREATED)
                            ->options(IssueStatus::class)
                            ->required(),

                        ToggleButtons::make('type')
                            ->label(Str::ucfirst(__('issues.issue_type')))
                            ->inline()
                            ->options(IssueType::class)
                            ->required(),

                        Textarea::make('description')
                            ->label(Str::ucfirst(__('app.description')))
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make(Str::ucfirst(__('issues.observations_and_attachments')))
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
                        Textarea::make('observations')
                            ->label(Str::ucfirst(__('app.observations')))
                            ->default(null)
                            ->columnSpanFull(),
                        FileUpload::make('images')
                            ->label(Str::ucfirst(__('app.photos')))
                            ->directory('issues/images')
                            ->visibility('public')
                            ->panelLayout('grid')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
