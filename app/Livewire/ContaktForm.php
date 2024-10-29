<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ContaktForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('data.name')
                    ->label('Nombre')
                    ->placeholder('Tu nombre')
                    ->required(),

                TextInput::make('data.email')
                    ->label('Email')
                    ->placeholder('Tu email')
                    ->email()
                    ->required(),

                TextInput::make('data.title')
                    ->label('Asunto')
                    ->placeholder('Asunto')
                    ->required(),

                Textarea::make('data.message')
                    ->label('Mensaje')
                    ->placeholder('Tu mensaje')
                    ->rows(5)
                    ->required()->minLength(5),
            ]);
    }

    public function save(): void
    {
        // Lógica para procesar el formulario, como enviar un correo o guardar en la base de datos
        dd($this->form->getState());
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render(): View
    {
        return view('livewire.contakt-form');
    }
}
