<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\Tax;
use Database\Factories\SecondHandMachineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecondHandMachine extends Model
{
    /** @use HasFactory<SecondHandMachineFactory> */
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'coste',
        'observaciones_compra',
        'modelo',
        'numero_serie',
        'precio_venta',
        'tax',
        'horas_trabajo',
        'descripcion',
        'estado',
        'taller_reparacion',
        'fotos',             // JSON array of paths
        'adjuntos',          // JSON array of paths
        'brand_id',
        'responsable_compra_id',
        'cliente_compra_id',
        'family_id',
    ];

    protected $casts = [
        'coste' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'taller_reparacion' => 'decimal:2',
        'tax' => Tax::class,
        'estado' => Status::class,
        'horas_trabajo' => 'integer',
        'fotos' => 'array',
        'adjuntos' => 'array',
    ];

    public function responsableCompra(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_compra_id');
    }

    public function clienteCompra(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_compra_id');
    }

    public function familia(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
