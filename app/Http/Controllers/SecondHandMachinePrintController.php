<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SecondHandMachine;
use Illuminate\Http\Request;

/**
 * Controlador para generar la vista de impresión/PDF de máquinas de segunda mano.
 *
 * @param  Request  $request  — parámetro 'campos[]' para seleccionar qué incluir
 * @param  SecondHandMachine  $secondhandmachine  — modelo de la máquina
 */
class SecondHandMachinePrintController extends Controller
{
    public function __invoke(Request $request, SecondHandMachine $secondhandmachine)
    {
        $campos = $request->input('campos', [
            'imagenes',
            'marca',
            'modelo',
            'codigo',
            'horas',
            'precio',
            'descripcion',
            'estado',
        ]);

        return view('secondhandmachines.print', [
            'machine' => $secondhandmachine,
            'campos' => is_array($campos) ? $campos : [$campos],
        ]);
    }
}
