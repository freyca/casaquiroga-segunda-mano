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
use Illuminate\Support\Str;

final class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(Str::ucfirst(__('secondhandmachines.general_information')))
                    ->schema([
                        TextInput::make('name')
                            ->label(Str::ucfirst(__('app.name')))
                            ->required(),

                        TextInput::make('identifier_code')
                            ->label(Str::ucfirst(__('app.identifier_code')))
                            ->required(),

                        Select::make('family_id')
                            ->label(Str::ucfirst(__('app.family')))
                            ->searchable()
                            ->relationship('family', 'name')
                            ->default(null)
                            ->createOptionForm(
                                FamilyForm::configure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        Select::make('brand_id')
                            ->label(Str::ucfirst(__('app.brand')))
                            ->searchable()
                            ->relationship('brand', 'name')
                            ->default(null)
                            ->createOptionForm(
                                BrandForm::configure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        TextInput::make('model')
                            ->label(Str::ucfirst(__('app.model')))
                            ->default(null),

                        TextInput::make('serial_number')
                            ->label(Str::ucfirst(__('app.serial_number')))
                            ->default(null),

                        TextInput::make('purchase_cost')
                            ->label(Str::ucfirst(__('app.purchase_cost')))
                            ->numeric()
                            ->suffix('€')
                            ->step(0.01)
                            ->default(null),

                        TextInput::make('repair_workshop')
                            ->label(Str::ucfirst(__('app.repair_workshop')))
                            ->default(null),

                        TextInput::make('work_hours')
                            ->label(Str::ucfirst(__('app.work_hours')))
                            ->suffix(__('app.hours'))
                            ->numeric()
                            ->default(null),

                        // @see: https://github.com/filamentphp/filament/discussions/17718
                        Tabs::make('description_tabs')
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('Editor')->schema([
                                    RichEditor::make(Str::ucfirst(__('app.description')))
                                        ->live()
                                        ->afterStateUpdated(fn (?string $state, Set $set): mixed => $set('description_html', $state))
                                        ->afterStateHydrated(fn (?string $state, Set $set): mixed => $set('description_html', $state)),
                                ]),
                                Tab::make('HTML')->schema([
                                    Textarea::make(Str::ucfirst(__('app.description_html')))
                                        ->live()
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

                Section::make(Str::ucfirst(__('secondhandmachines.sale_information')))
                    ->schema([
                        ToggleButtons::make('sell_status')
                            ->label(Str::ucfirst(__('app.sell_status')))
                            ->options(SellStatus::class)
                            ->default(SellStatus::Available)
                            ->inline()
                            ->columnSpanFull()
                            ->required(),

                        TextInput::make('selling_price')
                            ->label(Str::ucfirst(__('app.selling_price')))
                            ->numeric()
                            ->suffix('€')
                            ->step(0.01)
                            ->default(null),

                        Select::make('tax')
                            ->label(Str::ucfirst(__('app.tax')))
                            ->label('IVA')
                            ->options(Tax::class)
                            ->required()
                            ->default(Tax::Zero),

                        Select::make('employee_id')
                            ->label(Str::ucfirst(__('app.purchasing_manager')))
                            ->relationship(
                                name: 'seller',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('role', '!=', Role::User)
                            )
                            ->default(null),

                        Select::make('customer_id')
                            ->label(Str::ucfirst(__('app.customer')))
                            ->relationship(
                                name: 'customer',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('role', Role::User)
                            )
                            ->default(null)
                            ->searchable()
                            ->createOptionForm(
                                UserForm::partialConfigure(
                                    Schema::make()
                                )->getComponents()
                            ),

                        Textarea::make('purchase_notes')
                            ->label(Str::ucfirst(__('app.purchase_notes')))
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->collapsible(),

                Section::make(Str::ucfirst(__('app.attachments')))
                    ->schema([
                        FileUpload::make('photos')
                            ->label(Str::ucfirst(__('app.photos')))
                            ->hint(Str::ucfirst(__('app.photos_hint')))
                            ->image()
                            ->multiple()
                            ->directory('secondhandmachines/photos')
                            ->visibility('public')
                            ->panelLayout('grid')
                            ->reorderable(),

                        FileUpload::make('attachments')
                            ->label(Str::ucfirst(__('app.attachments')))
                            ->multiple()
                            ->directory('secondhandmachines/attachments')
                            ->visibility('public')
                            ->panelLayout('grid'),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }
}
