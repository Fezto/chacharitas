<div class="absolute top-10 left-0 right-0 flex justify-center items-center mt-40">
    <div class="bg-neutral shadow-lg rounded-lg p-8 max-w-md w-full">
        <form wire:submit="save">
            <!-- Campo Nombre -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre</label>
                <x-input wire:model="form.name" class="w-full" type="text" id="name" placeholder="Tu nombre" required/>
                @error('form.message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            </div>
            <!-- Campo Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <x-input wire:model="form.email" class="w-full" type="email" id="email" placeholder="Tu email" required/>
                @error('form.message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Campo Asunto -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">Asunto</label>
                <x-input wire:model="title" class="w-full" type="text" id="subject" placeholder="Asunto" required/>
                @error('form.message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Campo Mensaje -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Mensaje</label>
                <x-textarea wire:model="form.message" class="w-full" id="message" placeholder="Tu mensaje" rows="5" required></x-textarea>
                @error('form.message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Botón de envío -->
            <div class="flex justify-center">
                <button class="btn btn-primary w-full" style="background-color: #f1cad0; color: white;">Enviar
                </button>
            </div>
        </form>
    </div>
</div>
