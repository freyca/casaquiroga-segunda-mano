{{-- =============================================================================
     █ [BLADE_COMP] :: image-slider
     =============================================================================
     DESC:   Slider con thumbnails verticales (desktop) y flechas + swipe (móvil).
     USO:    <x-secondhandmachines.image-slider :images="$maquina->imagenes" :alt="$maquina->modelo" />
     PROPS:  images (array), alt (string)
     STATUS: STABLE
     ============================================================================= --}}
@props(['images' => [], 'alt' => ''])

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

</style>

@php
// Asegurar que images es un array
$imagesArray = is_array($images) ? $images : [];
$hasImages = !empty($imagesArray);
@endphp

@if(!$hasImages)
<div class="w-full flex flex-col items-center justify-center gap-3 text-gray-300 rounded-3xl bg-gray-50 dark:bg-gray-800" style="height:600px;">
    <x-heroicon-o-photo class="w-16 h-16" />
    <span class="text-sm font-medium">{{ ucfirst('no ' . __('photos')) }}</span>
</div>
@else
<div x-data="{
            diapositivaActual: 0,
            imagenes: {{ json_encode($imagesArray) }},
            loaded: {},
            anterior() { this.diapositivaActual = this.diapositivaActual === 0 ? this.imagenes.length - 1 : this.diapositivaActual - 1; },
            siguiente() { this.diapositivaActual = this.diapositivaActual === this.imagenes.length - 1 ? 0 : this.diapositivaActual + 1; },
            touchStartX: 0,
            onTouchStart(e) { this.touchStartX = e.changedTouches[0].clientX; },
            onTouchEnd(e) {
                const delta = e.changedTouches[0].clientX - this.touchStartX;
                if (Math.abs(delta) > 40) { delta < 0 ? this.siguiente() : this.anterior(); }
            },
        }" class="flex flex-row gap-4 w-full" style="height:600px;">
    @if(count($imagesArray) > 1)
    <div class="hidden md:flex flex-col items-center w-24 shrink-0">

        <x-filament::icon-button icon="heroicon-o-chevron-up" color="gray" size="sm" label="Imagen anterior" x-on:click="anterior()" class="mb-2 shrink-0" />

        <div class="flex flex-col gap-4 py-2 px-3 overflow-y-auto custom-scrollbar flex-1 w-full items-center">
            <template x-for="(imagen, indice) in imagenes" :key="indice">
                <button x-on:click="diapositivaActual = indice" :class="diapositivaActual === indice
                                ? 'ring-2 ring-gray-950 dark:ring-white ring-offset-2 opacity-100'
                                : 'opacity-50 hover:opacity-90'" class="relative shrink-0 w-16 h-16 rounded-xl overflow-hidden transition-all duration-200 bg-gray-100 dark:bg-gray-700">
                    <div x-show="!loaded[indice]" class="absolute inset-0 flex items-center justify-center">
                        <x-filament::loading-indicator class="h-4 w-4 text-gray-400" />
                    </div>
                    <img :src="`/storage/${imagen}`" @load="loaded[indice] = true" class="w-full h-full object-cover">
                </button>
            </template>
        </div>

        <x-filament::icon-button icon="heroicon-o-chevron-down" color="gray" size="sm" label="Imagen siguiente" x-on:click="siguiente()" class="mt-2 shrink-0" />

    </div>
    @endif

    <div class="relative flex-1 bg-gray-50 dark:bg-gray-800 rounded-3xl overflow-hidden" @touchstart="onTouchStart($event)" @touchend="onTouchEnd($event)">
        <div x-show="!loaded[diapositivaActual]" class="absolute inset-0 flex items-center justify-center z-10">
            <x-filament::loading-indicator class="h-8 w-8 text-gray-400" />
        </div>

        <template x-for="(imagen, indice) in imagenes" :key="indice">
            <img x-show="diapositivaActual === indice" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" :src="`/storage/${imagen}`" @load="loaded[indice] = true" alt="{{ $alt }}" class="absolute inset-0 w-full h-full object-cover">
        </template>

        @if(count($imagesArray) > 1)
        <div class="md:hidden flex items-center justify-between px-3 absolute inset-y-0 left-0 right-0 pointer-events-none">
            <x-filament::icon-button x-on:click="anterior()" icon="heroicon-o-chevron-left" size="lg" label="Imagen anterior" class="pointer-events-auto !bg-white/30 !backdrop-blur-md !border-0 hover:!bg-white/50 [&_*]:!text-white" />
            <x-filament::icon-button x-on:click="siguiente()" icon="heroicon-o-chevron-right" size="lg" label="Imagen siguiente" class="pointer-events-auto !bg-white/30 !backdrop-blur-md !border-0 hover:!bg-white/50 [&_*]:!text-white" />
        </div>
        @endif

        <div class="absolute bottom-5 right-5 bg-white/30 backdrop-blur-md text-white px-4 py-1 rounded-full text-sm font-medium pointer-events-none z-10">
            <span x-text="diapositivaActual + 1"></span> / <span x-text="imagenes.length"></span>
        </div>

    </div>
</div>
@endif
