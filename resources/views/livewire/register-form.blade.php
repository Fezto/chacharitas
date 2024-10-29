<div class="w-full max-w-xl shrink-0 shadow-2xl">
    <div class="bg-neutral shadow-lg rounded-lg p-8 max-w w-full">
        <form wire:submit="submit">
            {{ $this->form }}
            <x-filament-actions::modals/>
        </form>
    </div>
</div>
