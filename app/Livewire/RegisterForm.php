<?php

namespace App\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Información Personal')
                    ->schema([
                        TextInput::make('data.nombre')
                            ->label('Nombre')
                            ->required(),

                        TextInput::make('data.apellido_paterno')
                            ->label('Apellido Paterno')
                            ->required(),

                        TextInput::make('data.apellido_materno')
                            ->label('Apellido Materno')
                            ->required(),

                        TextInput::make('data.email')
                            ->label('Email')
                            ->email()
                            ->required(),

                        TextInput::make('data.password')
                            ->label('Password')
                            ->password()
                            ->required(),
                    ]),

                Wizard\Step::make('Dirección')
                    ->schema([
                        Select::make('data.estado')
                            ->label('Estado')
                            ->options(fn() => $this->getStates())
                            ->required(),

                        Select::make('data.municipio')
                            ->label('Municipio')
                            ->required(),

                        TextInput::make('data.calle')
                            ->label('Calle')
                            ->required(),

                        TextInput::make('data.codigo_postal')
                            ->label('Código Postal')
                            ->required(),
                    ]),
            ])->submitAction('Registrarse') // Define un texto para el botón de "submit"
        ]);
    }

    public function getStates(): array
    {
        return [
            '1' => 'Estado 1',
            '2' => 'Estado 2',
        ];
    }

    public function submit(): void
    {
        dd($this->form->getState());
    }

    public function render(): View
    {
        return view('livewire.register-form');
    }
}
