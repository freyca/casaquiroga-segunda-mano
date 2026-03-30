<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Familia extends Model
{
    /** @use HasFactory<\Database\Factories\FamiliaFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function secondHandMachines(): HasMany
    {
        return $this->hasMany(SecondHandMachine::class);
    }
}
