<x-filament-panels::page>
    {{-- You can access the record with $this->getRecord() --}}
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Máquina de segunda mano: {{ $this->getRecord()->nombre }}</h1>
        <ul class="space-y-2">
            <li><strong>Código:</strong> {{ $this->getRecord()->codigo }}</li>
            {{-- Samu's code --}}
        </ul>
    </div>
</x-filament-panels::page>
