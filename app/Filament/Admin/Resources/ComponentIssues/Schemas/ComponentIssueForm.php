<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ComponentIssues\Schemas;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Filament\Admin\Resources\Machines\Schemas\MachineForm;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

final class ComponentIssueForm
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

                        Textarea::make('description')
                            ->label(Str::ucfirst(__('app.description')))
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make(Str::ucfirst(__('issues.observations_and_attachments')))
                    ->columnSpanFull()
                    ->collapsible()
                    ->schema([
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
