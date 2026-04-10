<x-filament-panels::page>
    <style>
        [x-cloak] {
            display: none !important
        }

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

    <div
        class="grid grid-cols-1 lg:grid-cols-[5fr_7fr] gap-8 lg:gap-10 items-start max-w-6xl mx-auto"
        style="--anim-badge: 0ms; --anim-titulo: 100ms; --anim-precio: 200ms; --anim-specs: 300ms; --anim-spec1: 0ms; --anim-spec2: 100ms; --anim-spec3: 200ms; --anim-spec4: 300ms; --anim-desc: 400ms; --anim-acciones: 500ms; --anim-slider: 150ms;"
    >

        {{-- COLUMNA IZQUIERDA — info, specs, acciones --}}
        <div class="flex flex-col gap-4">
            <div class="fade-in self-start" style="animation-delay: var(--anim-badge);">
                <x-filament::badge :color="$record->sell_status->getColor()" size="sm">
                    {{ ucfirst(__($record->sell_status->getLabel())) }}
                </x-filament::badge>
            </div>

            <div class="fade-up" style="animation-delay: var(--anim-titulo);">
                <h1 class="text-5xl font-bold leading-tight tracking-tight">
                    {{ ucfirst($record->name) }}
                </h1>
            </div>

            <x-filament::card class="fade-up p-5" style="animation-delay: var(--anim-precio);">
                <p class="text-xs font-semibold uppercase tracking-widest mb-1">{{ ucfirst(__('selling_price'))}}</p>
                <p class="text-4xl font-bold leading-none">
                    {{ number_format($record->selling_price, 0, ',', '.') }}
                    <span class="text-xl font-normal">€</span>
                </p>
            </x-filament::card>

            <div class="grid grid-cols-2 gap-3 fade-up" style="animation-delay: var(--anim-specs);">
                <x-secondhandmachines.bento-spec label="{{ ucfirst(__('brand')) }}" :value="$record->brand?->name ?? 'Sin marca'" delay="0" />
                <x-secondhandmachines.bento-spec label="{{ ucfirst(__('model')) }}" :value="$record->model ?? '—'" delay="100" />
                <x-secondhandmachines.bento-spec label="{{ ucfirst(__('work_hours')) }}" :value="number_format($record->work_hours ?? 0, 0, ',', '.') . ' h'" delay="200" />
                <x-secondhandmachines.bento-spec label="{{ ucfirst(__('identifier_code')) }}" :value="$record->identifier_code ?? '—'" mono delay="300" />
            </div>

            @if($record->description)
            <x-filament::card class="fade-up p-5" style="animation-delay: var(--anim-desc); animation-fill-mode: both;">
                <p class="text-[10px] font-semibold uppercase tracking-widest opacity-70 mb-2">{{ ucfirst(__('description')) }}</p>
                <p class="text-sm leading-relaxed">{!! $record->description !!}</p>
            </x-filament::card>
            @endif

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
