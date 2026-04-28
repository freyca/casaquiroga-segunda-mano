<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Schemas;

use App\Enums\Role;
use App\Enums\SellStatus;
use App\Enums\Tax;
use App\Filament\Admin\Resources\Brands\Schemas\BrandForm;
use App\Filament\Admin\Resources\Families\Schemas\FamilyForm;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

final class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(Str::ucfirst(__('general_information')))
                    ->schema([
                        TextInput::make('name')
                            ->label(Str::ucfirst(__('name')))
                            ->required(),

                        TextInput::make('identifier_code')
                            ->label(Str::ucfirst(__('identifier_code')))
                            ->required(),

                        Select::make('family_id')
                            ->label(Str::ucfirst(__('family')))
                            ->searchable()
                            ->relationship('family', 'name')
                            ->default(null)
                            ->createOptionForm(
                                FamilyForm::configure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        Select::make('brand_id')
                            ->label(Str::ucfirst(__('brand')))
                            ->searchable()
                            ->relationship('brand', 'name')
                            ->default(null)
                            ->createOptionForm(
                                BrandForm::configure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        TextInput::make('model')
                            ->label(Str::ucfirst(__('model')))
                            ->default(null),

                        TextInput::make('serial_number')
                            ->label(Str::ucfirst(__('serial_number')))
                            ->default(null),

                        TextInput::make('purchase_cost')
                            ->label(Str::ucfirst(__('purchase_cost')))
                            ->numeric()
                            ->suffix('€')
                            ->step(0.01)
                            ->default(null),

                        TextInput::make('repair_workshop')
                            ->label(Str::ucfirst(__('repair_workshop')))
                            ->default(null),

                        TextInput::make('work_hours')
                            ->label(Str::ucfirst(__('work_hours')))
                            ->numeric()
                            ->default(null),

                        // @see: https://github.com/filamentphp/filament/discussions/17718
                        Tabs::make('description_tabs')
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('Editor')->schema([
                                    RichEditor::make('description')
                                        ->reactive()
                                        ->afterStateUpdated(fn (?string $state, Set $set): mixed => $set('description_html', $state))
                                        ->afterStateHydrated(fn (?string $state, Set $set): mixed => $set('description_html', $state)),
                                ]),
                                Tab::make('HTML')->schema([
                                    Textarea::make('description_html')
                                        ->rows(10)
                                        ->afterStateUpdated(fn (?string $state, Set $set): mixed => $set('description', $state))
                                        ->dehydrated(false),
                                ]),
                            ])
                            ->contained(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make(Str::ucfirst(__('sale_information')))
                    ->schema([
                        ToggleButtons::make('sell_status')
                            ->label(Str::ucfirst(__('sell_status')))
                            ->options(SellStatus::class)
                            ->default(SellStatus::Available)
                            ->inline()
                            ->columnSpanFull()
                            ->required(),

                        TextInput::make('selling_price')
                            ->label(Str::ucfirst(__('selling_price')))
                            ->numeric()
                            ->suffix('€')
                            ->step(0.01)
                            ->default(null),

                        Select::make('tax')
                            ->label(Str::ucfirst(__('tax')))
                            ->label('IVA')
                            ->options(Tax::class)
                            ->required()
                            ->default(0),

                        Select::make('employee_id')
                            ->label(Str::ucfirst(__('purchasing_manager')))
                            ->relationship(
                                name: 'seller',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('role', '!=', Role::User)
                            )
                            ->default(null),

                        Select::make('customer_id')
                            ->label(Str::ucfirst(__('customer')))
                            ->relationship(
                                name: 'customer',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('role', Role::User)
                            )
                            ->default(null)
                            ->createOptionForm(
                                UserForm::partialConfigure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        Textarea::make('purchase_notes')
                            ->label(Str::ucfirst(__('purchase_notes')))
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->collapsible(),

                Section::make(Str::ucfirst(__('attachments')))
                    ->schema([
                        FileUpload::make('photos')
                            ->label(Str::ucfirst(__('photos')))
                            ->hint(Str::ucfirst(__('photos_hint')))
                            ->image()
                            ->multiple()
                            ->directory('secondhandmachines/photos')
                            ->visibility('public')
                            ->panelLayout('grid')
                            ->reorderable(),

                        FileUpload::make('attachments')
                            ->label(Str::ucfirst(__('attachments')))
                            ->multiple()
                            ->directory('secondhandmachines/attachments')
                            ->visibility('public')
                            ->panelLayout('grid'),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make(Str::ucfirst(__('product_notes')))
                    ->label(Str::ucfirst(__('notes')))
                    ->schema([
                        Repeater::make('notes')
                            ->label(Str::ucfirst(__('notes')))
                            ->relationship()
                            ->default([])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->schema([
                                Select::make('user_id')
                                    ->label(Str::ucfirst(__('user')))
                                    ->relationship('user', 'name')
                                    ->disabled(),

                                TextInput::make('created_at')
                                    ->label(Str::ucfirst(__('created_at')))
                                    ->formatStateUsing(
                                        fn (mixed $state): ?string => $state
                                            ? Date::parse($state)->format('d-m-Y H:i') // @phpstan-ignore-line
                                            : null
                                    )
                                    ->disabled(),

                                TextInput::make('previous_state')
                                    ->label(Str::ucfirst(__('previous_state')))
                                    ->disabled()
                                    ->formatStateUsing(fn (string $state) => SellStatus::tryFrom($state)?->getLabel()),

                                TextInput::make('new_state')
                                    ->label(Str::ucfirst(__('new_state')))
                                    ->disabled()
                                    ->formatStateUsing(fn (string $state) => SellStatus::tryFrom($state)?->getLabel()),

                                Textarea::make('description')
                                    ->label(Str::ucfirst(__('new_state')))
                                    ->disabled()
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->hidden(fn (string $operation): bool => $operation === 'create'),
            ]);
    }
}
