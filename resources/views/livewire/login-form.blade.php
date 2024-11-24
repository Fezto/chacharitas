<div class="w-full max-w-xl shrink-0 shadow-2xl">
    @if(session('error'))
        <x-alert type="alert-error" class="rounded-none">
            {{ session('error') }}
        </x-alert>
    @endif

    <form wire:submit="submit">
        {{ $this->form }}
        <x-filament-actions::modals/>
    </form>
</div>
