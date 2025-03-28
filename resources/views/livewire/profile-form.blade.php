<div class="bg-white shadow-lg rounded-lg max-w-md w-full">
    @if(session('success'))
        <x-alert type="alert-success" class="rounded-none">
            {{ session('success') }}
        </x-alert>
    @endif
    <form wire:submit="save">
        {{ $this->form }}
    </form>

    <x-filament-actions::modals/>
</div>

