<x-filament::widget>
    <x-filament::card>
        <div>
            <div class="flex flex-row justify-between">
                <div class="text-left">
                    <p class="text-md font-bold">¿Quieres regresar?</p>
                    <p class="text-sm text-gray-600">Haz clic en el botón para ir al sitio.</p>
                </div>
                <div class="mt-4">
                    @foreach ($this->getActions() as $action)
                        {{ $action }}
                    @endforeach
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
