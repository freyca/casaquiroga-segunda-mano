{{-- =============================================================================
     █ [BLADE_COMP] :: toggle-switch
     =============================================================================
     DESC:   Toggle switch estilizado con colores neutros.
     USO:    <x-toggle-switch x-model="variable" />
     PROPS:  model (required) - binding de Alpine
     STATUS: STABLE
     ============================================================================= --}}
@props(['model' => null])

<div
    role="switch"
    type="button"
    x-on:click="{{ $model }} = ! {{ $model }}"
    :aria-checked="{{ $model }}?.toString()"
    :data-state="{{ $model }} ? 'on' : 'off'"
    :class="{{ $model }} ? 'bg-gray-700 dark:bg-gray-400' : 'bg-gray-300 dark:bg-gray-600'"
    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
>
    <span
        aria-hidden="true"
        class="pointer-events-none inline-block rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        :class="{{ $model }} ? 'translate-x-4' : 'translate-x-0'"
        style="width: 0.875rem; height: 0.875rem; transform: translateX(0);"
    ></span>
</div>