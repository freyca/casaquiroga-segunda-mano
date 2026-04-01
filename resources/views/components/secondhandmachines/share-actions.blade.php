{{-- =============================================================================
     █ [BLADE_COMP] :: share-actions
     =============================================================================
     DESC:   Botones de compartir (Web Share API / clipboard) y exportar PDF.
     USO:    <x-secondhandmachines.share-actions :maquina="$record" />
     PROPS:  maquina (SecondHandMachine)
     STATUS: STABLE
     ============================================================================= --}}
@props(['maquina'])

<div x-data="{
        panel: false,
        copied: false,
        show_fields: {
            photos:          true,
            brand:           true,
            model:           true,
            identifier_code: true,
            work_hours:      true,
            selling_price:   true,
            description:     true,
            sell_status:     false,
        },
        exportar() {
            const fields = Object.entries(this.show_fields)
                .filter(([_, v]) => v)
                .map(([k]) => k)
                .join(',');

            const url = '{{ route('secondhandmachines.print', $maquina) }}'
                + (fields ? `?show_fields=${fields}` : '');

            window.open(url, '_blank');
        }
    }" class="flex flex-col gap-3">
    <div class="grid grid-cols-1">


        <x-filament::button x-on:click="panel = true" color="gray" size="lg" icon="heroicon-o-document-arrow-down" class="w-full rounded-2xl! justify-center bg-gray-950 dark:bg-white text-white dark:text-gray-950 hover:opacity-80">
            {{ ucfirst(__('print / save PDF')) }}
        </x-filament::button>

    </div>

    <div x-show="panel" style="display:none" class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 flex flex-col gap-4 transition-all duration-200 hover:shadow-lg">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">
                {{ ucfirst(__('include in document')) }}
            </p>
            <div class="grid grid-cols-2 gap-2">
                @foreach([
                'photos',
                'brand',
                'model',
                'identifier_code',
                'work_hours',
                'selling_price',
                'description',
                'sell_status',
                ] as $key)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <x-toggle-switch :model="'show_fields.' . $key" />
                    <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                        {{ ucfirst(__($key)) }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-2 pt-1">
            <x-filament::button outlined color="gray" size="lg" x-on:click="panel = false" class="flex-1 rounded-xl! justify-center">
                {{ ucfirst(__('cancel')) }}
            </x-filament::button>

            <x-filament::button color="gray" icon="heroicon-o-printer" size="lg" x-on:click="panel = false; $nextTick(() => exportar())" class="flex-1 rounded-xl! justify-center">
                {{ ucfirst(__('open document')) }}
            </x-filament::button>
        </div>

    </div>
</div>
