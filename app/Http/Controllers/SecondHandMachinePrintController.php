<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SecondHandMachine;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class SecondHandMachinePrintController extends Controller
{
    public function __invoke(Request $request, SecondHandMachine $secondhandmachine): View
    {
        $show_fields = (array) $request->input('show_fields', [
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
            'show_fields' => $show_fields,
        ]);
    }
}
