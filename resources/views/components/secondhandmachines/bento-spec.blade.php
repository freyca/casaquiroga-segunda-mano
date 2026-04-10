{{-- =============================================================================
     █ [BLADE_COMP] :: bento-spec
     =============================================================================
     DESC:   Celda de especificación con label, valor y botón copiar al portapapeles.
     USO:    <x-secondhandmachines.bento-spec label="Marca" :value="$record->brand?->nombre" />
     PROPS:  label (string), value (string), mono (bool) — fuente monoespaciada, delay (int)
     STATUS: STABLE
     ============================================================================= --}}
@props(['label', 'value', 'mono' => false, 'delay' => 0])

<x-filament::section x-data="{ copied: false, hovering: false }" @mouseenter="hovering = true" @mouseleave="hovering = false" class="group relative h-full fade-up transition-all duration-200 hover:-translate-y-0.5" @style(["animation-delay: {$delay}ms"])
>
    <p class="text-[10px] font-semibold uppercase tracking-widest opacity-70 mb-1">{{ $label }}</p>

    <div class="flex items-center justify-between gap-2">
        <p class="font-semibold truncate {{ $mono ? 'text-xs font-mono' : 'text-sm' }}">
            {{ $value }}
        </p>

        <div :class="copied || hovering ? 'opacity-100' : 'opacity-0'" class="shrink-0 transition-opacity duration-150">
            <x-filament::icon-button type="button" icon="heroicon-o-clipboard-document" color="gray" size="xs" :label="ucfirst(__('copy'))" x-show="!copied" x-on:click="navigator.clipboard.writeText('{{ addslashes($value) }}'); copied = true; setTimeout(() => copied = false, 2000)" />
            <x-filament::icon-button type="button" icon="heroicon-o-check" color="success" size="xs" :label="ucfirst(__('copied'))" x-show="copied" style="display: none;" x-on:click.prevent />
        </div>
    </div>
</x-filament::section>
