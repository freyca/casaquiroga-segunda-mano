<?php

declare(strict_types=1);

namespace App\Filament\Employee\Resources\SecondHandMachines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SecondHandMachineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('codigo'),
                TextEntry::make('nombre'),
                TextEntry::make('coste')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('responsableCompra.name')
                    ->label('Responsable compra')
                    ->placeholder('-'),
                TextEntry::make('clienteCompra.name')
                    ->label('Cliente compra')
                    ->placeholder('-'),
                TextEntry::make('observaciones_compra')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('familia.id')
                    ->label('Familia')
                    ->placeholder('-'),
                TextEntry::make('marca.id')
                    ->label('Marca')
                    ->placeholder('-'),
                TextEntry::make('modelo')
                    ->placeholder('-'),
                TextEntry::make('numero_serie')
                    ->placeholder('-'),
                TextEntry::make('precio_venta')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('taller_reparacion')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('tax')
                    ->badge()
                    ->numeric(),
                TextEntry::make('horas_trabajo')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('descripcion')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('estado')
                    ->badge(),
                TextEntry::make('fotos')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('adjuntos')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
