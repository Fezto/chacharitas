<div class="absolute top-10 left-0 right-0 flex justify-center items-center mt-40">
    <div class="bg-neutral shadow-lg rounded-lg p-8 max-w-md w-full">
        <form wire:submit="create">
            {{ $this->form }}

            <div class="flex justify-center mt-5">
                <button class="btn btn-primary w-full " >Envia
                </button>
            </div>
        </form>

        <x-filament-actions::modals/>
    </div>
</div>
