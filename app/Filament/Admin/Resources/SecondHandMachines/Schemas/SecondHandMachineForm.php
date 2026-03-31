<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Schemas;

use App\Enums\Status;
use App\Enums\Tax;
use App\Filament\Admin\Resources\Brands\Schemas\BrandForm;
use App\Filament\Admin\Resources\Families\Schemas\FamilyForm;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')->schema([
                    TextInput::make('name')
                        ->required(),

                    TextInput::make('codigo')
                        ->required(),

                    Select::make('family_id')
                        ->searchable()
                        ->relationship('family', 'name')
                        ->default(null)
                        ->createOptionForm(
                            FamilyForm::configure(
                                Schema::make()
                            )->getComponents()
                        ),

                    Select::make('brand_id')
                        ->searchable()
                        ->relationship('brand', 'name')
                        ->default(null)
                        ->createOptionForm(
                            BrandForm::configure(
                                Schema::make()
                            )->getComponents()
                        ),

                    TextInput::make('modelo')
                        ->default(null),

                    TextInput::make('serial_number')
                        ->default(null),

                    TextInput::make('coste')
                        ->numeric()
                        ->suffix('€')
                        ->step(0.01)
                        ->default(null),

                    TextInput::make('taller_reparacion')
                        ->numeric()
                        ->suffix('€')
                        ->step(0.01)
                        ->default(null),

                    TextInput::make('work_hours')
                        ->numeric()
                        ->default(null),

                    Textarea::make('description')
                        ->default(null)
                        ->columnSpanFull(),
                ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make('Adjuntos')->schema([
                    FileUpload::make('fotos')
                        ->image()
                        ->multiple()
                        ->directory('secondhandmachines/photos')
                        ->visibility('public')
                        ->panelLayout('grid'),

                    FileUpload::make('adjuntos')
                        ->multiple()
                        ->directory('secondhandmachines/attachments')
                        ->visibility('public')
                        ->panelLayout('grid'),
                ])
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make('Información venta')->schema([
                    ToggleButtons::make('sell_status')
                        ->options(Status::class)
                        ->default(Status::Disponible)
                        ->inline()
                        ->columnSpanFull()
                        ->required(),

                    TextInput::make('selling_price')
                        ->numeric()
                        ->suffix('€')
                        ->step(0.01)
                        ->default(null),

                    Select::make('tax')
                        ->label('IVA')
                        ->options(Tax::class)
                        ->required()
                        ->default(0),

                    Select::make('responsable_compra_id')
                        ->label('Vendedor')
                        ->relationship('seller', 'name')
                        ->default(null),

                    Select::make('cliente_compra_id')
                        ->label('Cliente')
                        ->relationship('customer', 'name')
                        ->default(null)
                        ->createOptionForm(
                            UserForm::partialConfigure(
                                Schema::make()
                            )->getComponents()
                        ),

                    Textarea::make('purchase_notes')
                        ->default(null)
                        ->columnSpanFull(),
                ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->collapsible(),

                Section::make('Notas')->schema([
                    Repeater::make('notes')
                        ->relationship()
                        ->default([])
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->disabled(),

                            TextInput::make('created_at')
                                ->label('Creada en')
                                ->formatStateUsing(
                                    fn($state) => $state
                                        ? Carbon::parse($state)->format('d-m-Y H:i') // @phpstan-ignore-line
                                        : null
                                )
                                ->disabled(),

                            TextInput::make('previous_state')
                                ->disabled()
                                ->formatStateUsing(fn($state) => Status::tryFrom($state)?->getLabel()),  // @phpstan-ignore-line

                            TextInput::make('new_state')
                                ->disabled()
                                ->formatStateUsing(fn($state) => Status::tryFrom($state)?->getLabel()), // @phpstan-ignore-line

                            Textarea::make('description')
                                ->disabled()
                                ->columnSpanFull(),
                        ])->columns(2),
                ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->hidden(fn(string $operation): bool => $operation === 'create'),
            ]);
    }
}
