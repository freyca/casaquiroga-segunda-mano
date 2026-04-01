<x-filament-panels::page>
    <style>
        [x-cloak] {
            display: none !important
        }

    </style>

    @php
    $record = $this->getRecord();

    $badgeColor = match($record->sell_status?->value) {
    'disponible' => 'success',
    'reservada' => 'warning',
    'vendida' => 'danger',
    'en_preparacion' => 'gray',
    'proxima_entrada' => 'info',
    default => 'gray',
    };

    $badgeLabel = match($record->sell_status?->getLabel()){
    'disponible' => 'Disponible',
    'reservada' => 'Reservada',
    'vendida' => 'Vendida',
    'en_preparacion' => 'En preparacion',
    'proxima_entrada' => 'Entrada Proxima',
    default => $record->sell_status?->getLabel(),
    };

    $anim = [
    'badge' => 0,
    'titulo' => 100,
    'precio' => 200,
    'specs' => 300,
    'spec1' => 0,
    'spec2' => 100,
    'spec3' => 200,
    'spec4' => 300,
    'desc' => 400,
    'acciones' => 500,
    'slider' => 150,
    ];
    @endphp

    <style>
        .fade-up {
            animation: fadeUp 0.5s cubic-bezier(0.22, 0.68, 0, 1.2) both;
        }

        .fade-in {
            animation: fadeIn 0.4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

    </style>

    <div class="grid grid-cols-1 lg:grid-cols-[5fr_7fr] gap-8 lg:gap-10 items-start max-w-6xl mx-auto" style="--anim-badge: {{ $anim['badge'] }}ms; --anim-titulo: {{ $anim['titulo'] }}ms; --anim-precio: {{ $anim['precio'] }}ms; --anim-specs: {{ $anim['specs'] }}ms; --anim-spec1: {{ $anim['spec1'] }}ms; --anim-spec2: {{ $anim['spec2'] }}ms; --anim-spec3: {{ $anim['spec3'] }}ms; --anim-spec4: {{ $anim['spec4'] }}ms; --anim-desc: {{ $anim['desc'] }}ms; --anim-acciones: {{ $anim['acciones'] }}ms; --anim-slider: {{ $anim['slider'] }}ms;">

        {{-- COLUMNA IZQUIERDA — info, specs, acciones --}}
        <div class="flex flex-col gap-4">

            <div class="fade-in self-start" style="animation-delay: var(--anim-badge);">
                <x-filament::badge :color="$badgeColor" size="sm">
                    {{ $badgeLabel }}
                </x-filament::badge>
            </div>

            <div class="fade-up" style="animation-delay: var(--anim-titulo);">
                <p class="text-xs font-semibold tracking-widest uppercase text-gray-400 mb-1">{{ $record->brand?->name ?? 'Sin marca' }}</p>
                <h1 class="text-5xl font-bold text-gray-950 dark:text-white leading-tight tracking-tight">
                    {{ $record->model ?? 'Sin modelo' }}
                </h1>
                <p class="text-sm text-gray-400 mt-2 font-mono">{{ $record->identifier_code }}</p>
            </div>

            <x-filament::card class="fade-up p-5 bg-gray-950 dark:bg-gray-900 border-transparent" style="animation-delay: var(--anim-precio);">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-1">Precio de venta</p>
                <p class="text-4xl font-bold text-white leading-none">
                    {{ number_format($record->selling_price, 0, ',', '.') }}
                    <span class="text-xl font-normal text-gray-500">€</span>
                </p>
            </x-filament::card>

            <div class="grid grid-cols-2 gap-3 fade-up" style="animation-delay: var(--anim-specs);">
                <x-secondhandmachines.bento-spec label="Marca" :value="$record->brand?->name ?? 'Sin marca'" delay="{{ $anim['spec1'] }}" />
                <x-secondhandmachines.bento-spec label="Modelo" :value="$record->model ?? '—'" delay="{{ $anim['spec2'] }}" />
                <x-secondhandmachines.bento-spec label="Horas trabajo" :value="number_format($record->work_hours ?? 0, 0, ',', '.') . ' h'" delay="{{ $anim['spec3'] }}" />
                <x-secondhandmachines.bento-spec label="Referencia" :value="$record->identifier_code ?? '—'" mono delay="{{ $anim['spec4'] }}" />
            </div>

            @if($record->description)
            <x-filament::card class="fade-up p-5" style="animation-delay: var(--anim-desc); animation-fill-mode: both;">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">Descripción</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $record->description }}</p>
            </x-filament::card>
            @endif

            <div class="fade-up" style="animation-delay: var(--anim-acciones);">
                <x-secondhandmachines.share-actions :maquina="$record" />
            </div>

        </div>

        {{-- COLUMNA DERECHA — slider de imágenes --}}
        @php
        $photosArray = is_array($record->photos) ? $record->photos : [];
        @endphp
        <div class="fade-in" style="animation-delay: var(--anim-slider);">
            <x-secondhandmachines.image-slider :images="$record->photos ?? []" :alt="$record->model" />
        </div>

    </div>
</x-filament-panels::page>
