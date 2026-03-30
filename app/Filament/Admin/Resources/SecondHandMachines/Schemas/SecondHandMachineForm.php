<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Schemas;

use App\Enums\Status;
use App\Enums\Tax;
use Filament\Forms\Components\FileUpload;
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
                    TextInput::make('nombre')
                        ->required(),

                    TextInput::make('codigo')
                        ->required(),

                    Select::make('family_id')
                        ->searchable()
                        ->relationship('family', 'nombre')
                        ->default(null),

                    Select::make('brand_id')
                        ->searchable()
                        ->relationship('brand', 'nombre')
                        ->default(null),

                    TextInput::make('modelo')
                        ->default(null),

                    TextInput::make('numero_serie')
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

                    TextInput::make('horas_trabajo')
                        ->numeric()
                        ->default(null),

                    Textarea::make('descripcion')
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
                    ToggleButtons::make('estado')
                        ->options(Status::class)
                        ->default(Status::Disponible)
                        ->inline()
                        ->columnSpanFull()
                        ->required(),

                    TextInput::make('precio_venta')
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
                        ->default(null),

                    Textarea::make('observaciones_compra')
                        ->default(null)
                        ->columnSpanFull(),
                ])
                    ->columnSpanFull()
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
