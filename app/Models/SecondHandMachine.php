<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use App\Enums\Tax;
use Database\Factories\SecondHandMachineFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
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
    'fotos',
    'adjuntos',
    'brand_id',
    'responsable_compra_id',
    'cliente_compra_id',
    'family_id',
])]
class SecondHandMachine extends Model
{
    /** @use HasFactory<SecondHandMachineFactory> */
    use HasFactory;

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

    /**
     * @return BelongsTo<User, $this>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_compra_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_compra_id');
    }

    /**
     * @return BelongsTo<Family, $this>
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
