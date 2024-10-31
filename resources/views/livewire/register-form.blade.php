<div class="bg-neutral w-full max-w-xl shrink-0 shadow-2xl">
    <form wire:submit="submit">
        {{ $this->form }}
        <x-filament-actions::modals/>
    </form>

    <div x-data="{ showAlert: false }" x-init="@this.on('formSubmitted', () => { showAlert = true; setTimeout(() => showAlert = false, 3000); })">
        <div x-show="showAlert" role="alert" class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Your purchase has been confirmed!</span>
        </div>
    </div>
</div>
