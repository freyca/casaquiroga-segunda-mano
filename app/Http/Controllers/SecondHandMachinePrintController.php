<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SecondHandMachine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Controlador para generar la vista de impresión/PDF de máquinas de segunda mano.
 *
 * @codeCoverageIgnore
 *
 * @param  Request  $request  — parámetro 'campos[]' para seleccionar qué incluir
 * @param  SecondHandMachine  $secondhandmachine  — modelo de la máquina
 */
final class SecondHandMachinePrintController extends Controller
{
    public function __invoke(Request $request, SecondHandMachine $secondhandmachine): Factory|View
    {
        $campos = $request->input('campos', [
            'photos',
            'brand',
            'model',
            'identifier_code',
            'work_hours',
            'selling_price',
            'description',
            'sell_status',
        ]);

        return view('secondhandmachines.print', [
            'machine' => $secondhandmachine,
            'campos' => is_array($campos) ? $campos : [$campos],
        ]);
    }
}
