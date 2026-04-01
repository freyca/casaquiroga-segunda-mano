{{-- =============================================================================
     █ [BLADE_COMP] :: bento-spec
     =============================================================================
     DESC:   Celda de especificación con label, valor y botón copiar al portapapeles.
     USO:    <x-secondhandmachines.bento-spec label="Marca" :value="$record->brand?->nombre" />
     PROPS:  label (string), value (string), mono (bool) — fuente monoespaciada, delay (int)
     STATUS: STABLE
     ============================================================================= --}}
@props(['label', 'value', 'mono' => false, 'delay' => 0])

<div x-data="{ copied: false, hovering: false }" @mouseenter="hovering = true" @mouseleave="hovering = false" class="group relative rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-4 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg fade-up" @style(["animation-delay: {$delay}ms"])>
    <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-1">{{ $label }}</p>

    <div class="flex items-center justify-between gap-2">

        <p class="font-semibold text-gray-700 dark:text-gray-200 truncate {{ $mono ? 'text-xs font-mono' : 'text-sm' }}">
            {{ $value }}
        </p>

        <div :class="copied || hovering ? 'opacity-100' : 'opacity-0'" class="shrink-0 transition-opacity duration-150">
            <button @click="navigator.clipboard.writeText('{{ addslashes($value) }}'); copied = true; setTimeout(() => copied = false, 2000)" :class="copied ? 'text-green-500 dark:text-green-400' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300'" class="transition-colors duration-150" title="{{ ucfirst(__('copy')) }}">
                <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="9" y="9" width="13" height="13" rx="2" />
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                </svg>
                <svg x-show="copied" style="display:none" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>

    </div>
</div>
