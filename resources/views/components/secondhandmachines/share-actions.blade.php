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
        campos: {
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
            const params = new URLSearchParams();
            Object.entries(this.campos).forEach(([k, v]) => {
                if (v) params.append('campos[]', k);
            });
            window.open('{{ route('secondhandmachines.print', $maquina) }}?' + params.toString(), '_blank');
        }
    }" class="flex flex-col gap-3">
    <div class="grid grid-cols-1">


        <x-filament::button x-on:click="panel = true" color="gray" size="lg" icon="heroicon-o-document-arrow-down" class="w-full rounded-2xl! justify-center bg-gray-950 dark:bg-white text-white dark:text-gray-950 hover:opacity-80">
            Exportar PDF
        </x-filament::button>

    </div>

    <div x-show="panel" style="display:none" class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4 flex flex-col gap-4 transition-all duration-200 hover:shadow-lg">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">
                Incluir en el documento
            </p>
            <div class="grid grid-cols-2 gap-2">
                @foreach([
                'photos' => 'Imágenes',
                'brand' => 'Marca',
                'model' => 'Modelo',
                'identifier_code' => 'Código ref.',
                'work_hours' => 'Horas de uso',
                'selling_price' => 'Precio',
                'description' => 'Descripción',
                'sell_status' => 'Estado',
                ] as $key => $label)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <x-toggle-switch :model="'campos.' . $key" />
                    <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                        {{ $label }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-2 pt-1">
            <x-filament::button outlined color="gray" size="lg" x-on:click="panel = false" class="flex-1 rounded-xl! justify-center">
                Cancelar
            </x-filament::button>

            <x-filament::button color="gray" icon="heroicon-o-printer" size="lg" x-on:click="panel = false; $nextTick(() => exportar())" class="flex-1 rounded-xl! justify-center">
                Abrir documento
            </x-filament::button>
        </div>

    </div>
</div>
