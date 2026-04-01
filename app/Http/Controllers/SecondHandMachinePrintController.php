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
        $default_fields = [
            'photos',
            'brand',
            'model',
            'identifier_code',
            'selling_price',
            'description',
        ];

        $show_fields = $request->filled('show_fields')
            ? explode(',', (string) $request->string('show_fields'))
            : $default_fields;

        return view('secondhandmachines.print', [
            'machine' => $secondhandmachine,
            'show_fields' => $show_fields,
        ]);
    }
}
