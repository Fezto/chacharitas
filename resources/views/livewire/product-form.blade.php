<div class="w-full max-w-xl shrink-0 shadow-2xl">
    <form wire:submit="submit">
        {{ $this->form }}
        <x-filament-actions::modals/>
    </form>
</div>
