<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $machine->brand?->nombre }} {{ $machine->modelo }} — {{ $machine->codigo }}</title>
    {{-- =============================================================================
         █ [BLADE_PAGE] :: secondhandmachine-print-page
         DESC:   Vista de impresión/PDF para máquina de segunda mano.
         VAR:    $machine (SecondHandMachine) — inyectado desde SecondHandMachinePrintController
                 $campos (array) — campos a incluir en el documento
         ADAPT: ORIGEN: maquina-product-page → DESTINO: SecondHandMachine
         STATUS: STABLE
         ============================================================================= --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: #fff;
            color: #111;
            font-size: 13px;
            line-height: 1.5;
        }

        .page {
            max-width: 860px;
            margin: 0 auto;
            padding: 48px 48px 64px;
        }

        /* ── CABECERA ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid #111;
            margin-bottom: 36px;
        }
        .header-left .company {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 6px;
        }
        .header-left .title {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -.02em;
        }
        .header-left .subtitle {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: #999;
            margin-top: 4px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .ref-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #999;
        }
        .header-right .ref {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            font-weight: 600;
        }
        .badge {
            display: inline-block;
            margin-top: 8px;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            border-radius: 99px;
            border: 1px solid #111;
        }

        /* ── IMAGEN ── */
        .images-grid {
            display: grid;
            gap: 8px;
            margin-bottom: 32px;
        }
        .images-grid.cols-1 { grid-template-columns: 1fr; }
        .images-grid.cols-2 { grid-template-columns: 1fr 1fr; }
        .images-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .images-grid img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            border-radius: 8px;
        }
        .images-grid.cols-1 img { aspect-ratio: 16/7; }

        .specs-grid {
            display: grid;
            gap: 1px;
        }
        .specs-grid.specs-1 { grid-template-columns: 1fr; }
        .specs-grid.specs-2 { grid-template-columns: 1fr 1fr; }
        .spec-item {
            background: #fff;
            padding: 14px 18px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin: -1px;
        }
        .spec-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 3px;
        }
        .spec-value {
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }
        .spec-value.mono {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
        }
        .price-box {
            background: #111;
            color: #fff;
            padding: 18px 24px;
            border-radius: 8px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .price-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #9ca3af;
        }
        .price-value {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -.02em;
        }
        .price-currency {
            font-size: 16px;
            font-weight: 400;
            color: #9ca3af;
        }

        /* ── DESCRIPCIÓN ── */
        .section-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .description {
            font-size: 13px;
            color: #444;
            line-height: 1.7;
            padding: 16px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 28px;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 48px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #9ca3af;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ── PRINT ── */
        @media print {
            body { background: #fff; }
            .page { padding: 24px; max-width: 100%; }
            .no-print { display: none !important; }
            @page { margin: 1cm; size: A4; }
        }

        /* ── BOTONES PANTALLA ── */
        .screen-actions {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
        }
        .btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            border-radius: 99px;
            cursor: pointer;
            border: none;
            transition: opacity .15s;
        }
        .btn:hover { opacity: .8; }
        .btn-primary { background: #111; color: #fff; }
        .btn-secondary { background: #fff; color: #111; border: 1px solid #e5e7eb; }
    </style>
</head>
<body>

<div class="page">

    {{-- CABECERA --}}
    <div class="header">
        <div class="header-left">
            <p class="company">Ficha técnica de producto</p>
            <h1 class="title">{{ $machine->modelo }}</h1>
            <p class="subtitle">{{ $machine->brand?->nombre }}</p>
        </div>
        <div class="header-right">
            <p class="ref-label">Referencia</p>
            <p class="ref">{{ $machine->codigo }}</p>
            @if(in_array('estado', $campos) && $machine->estado)
                <span class="badge">{{ $machine->estado->getLabel() }}</span>
            @endif
        </div>
    </div>

    {{-- IMÁGENES --}}
    @if(in_array('imagenes', $campos) && $machine->fotos && count($machine->fotos) > 0)
        @php
            $imgs = array_slice($machine->fotos, 0, 3);
            $cols = count($imgs) === 1 ? 'cols-1' : (count($imgs) === 2 ? 'cols-2' : 'cols-3');
        @endphp
        <div class="images-grid {{ $cols }}">
            @foreach($imgs as $img)
                <img src="{{ $img }}" alt="{{ $machine->modelo }}">
            @endforeach
        </div>
    @endif

    {{-- PRECIO --}}
    @if(in_array('precio', $campos))
        <div class="price-box">
            <p class="price-label">Precio de venta</p>
            <p class="price-value">
                {{ number_format($machine->precio_venta, 0, ',', '.') }}
                <span class="price-currency">EUR</span>
            </p>
        </div>
    @endif

    {{-- SPECS --}}
    @php
        $specs = [];
        if (in_array('marca', $campos))   $specs[] = ['Marca',      $machine->brand?->nombre ?? '—', false];
        if (in_array('modelo', $campos))  $specs[] = ['Modelo',     $machine->modelo ?? '—',       false];
        if (in_array('horas', $campos))   $specs[] = ['Horas de uso', number_format($machine->horas_trabajo ?? 0, 0, ',', '.') . ' h', false];
        if (in_array('codigo', $campos))  $specs[] = ['Referencia', $machine->codigo ?? '—',       true];
    @endphp

    @if(count($specs))
        <div class="specs-grid specs-{{ min(count($specs), 2) }}">
            @foreach($specs as [$label, $value, $mono])
                <div class="spec-item">
                    <p class="spec-label">{{ $label }}</p>
                    <p class="spec-value {{ $mono ? 'mono' : '' }}">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- DESCRIPCIÓN --}}
    @if(in_array('descripcion', $campos) && $machine->descripcion)
        <p class="section-label">Descripción</p>
        <div class="description">{{ $machine->descripcion }}</div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <span>Maquinaria Industrial S.L.</span>
        <span>{{ $machine->codigo }} — Generado el {{ now()->format('d/m/Y') }}</span>
    </div>

</div>

{{-- Botones solo en pantalla, no al imprimir --}}
<div class="screen-actions no-print">
    <button class="btn btn-secondary" onclick="window.close()">Cerrar</button>
    <button class="btn btn-primary" onclick="window.print()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Imprimir / Guardar PDF
    </button>
</div>

</body>
</html>
