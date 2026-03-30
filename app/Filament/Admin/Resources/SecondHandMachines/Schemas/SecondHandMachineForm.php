<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SecondHandMachines\Schemas;

use App\Enums\Status;
use App\Enums\Tax;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SecondHandMachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('coste')
                    ->numeric()
                    ->default(null),
                Select::make('responsable_compra_id')
                    ->relationship('seller', 'name')
                    ->default(null),
                Select::make('cliente_compra_id')
                    ->relationship('customer', 'name')
                    ->default(null),
                Textarea::make('observaciones_compra')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('family_id')
                    ->relationship('family', 'nombre')
                    ->default(null),
                Select::make('brand_id')
                    ->relationship('brand', 'nombre')
                    ->default(null),
                TextInput::make('modelo')
                    ->default(null),
                TextInput::make('numero_serie')
                    ->default(null),
                TextInput::make('precio_venta')
                    ->numeric()
                    ->default(null),
                TextInput::make('taller_reparacion')
                    ->numeric()
                    ->default(null),
                Select::make('tax')
                    ->options(Tax::class)
                    ->required()
                    ->default(0),
                TextInput::make('horas_trabajo')
                    ->numeric()
                    ->default(null),
                Textarea::make('descripcion')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('estado')
                    ->options(Status::class)
                    ->default('disponible')
                    ->required(),
                Textarea::make('fotos')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('adjuntos')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
