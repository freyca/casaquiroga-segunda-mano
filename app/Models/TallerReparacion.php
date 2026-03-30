<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TallerReparacion extends Model
{
    /** @use HasFactory<\Database\Factories\TallerReparacionFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function secondHandMachines(): HasMany
    {
        return $this->hasMany(SecondHandMachine::class);
    }
}
