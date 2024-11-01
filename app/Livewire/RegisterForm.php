<?php

namespace App\Livewire;

use App\Models\Municipality;
use App\Models\Neighborhood;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class RegisterForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public array $municipalities = [];
    public array $neighborhoods = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function updatedDataEstado($value)
    {
        $this->municipalities = Municipality::where('state_id', $value)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
        $this->data['municipio'] = null;
        $this->neighborhoods = [];
        $this->data['colonia'] = null;
    }

    public function updatedDataMunicipio($value)
    {
        $this->neighborhoods = Neighborhood::where('municipality_id', $value)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
        $this->data['colonia'] = null;
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Información Personal')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            TextInput::make('data.nombre')
                                ->label('Nombre')
                                ->placeholder('Ingrese su nombre')
                                ->required(),

                            TextInput::make('data.apellido_paterno')
                                ->label('Apellido Paterno')
                                ->placeholder('Ingrese su apellido paterno')
                                ->required(),

                            TextInput::make('data.apellido_materno')
                                ->label('Apellido Materno')
                                ->placeholder('Ingrese su apellido materno')
                                ->required(),

                            TextInput::make('data.email')
                                ->label('Email')
                                ->email()
                                ->placeholder('Ingrese su email')
                                ->required(),

                            TextInput::make('data.password')
                                ->label('Contraseña')
                                ->password()
                                ->placeholder('Ingrese su contraseña')
                                ->required(),

                            TextInput::make('data.password_confirmation')
                                ->label('Confirmar Contraseña')
                                ->password()
                                ->placeholder('Confirme su contraseña')
                                ->same('data.password')
                                ->required(),
                        ]),
                    ]),

                Wizard\Step::make('Dirección')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            Select::make('data.estado')
                                ->label('Estado')
                                ->options(fn() => State::orderBy('name')->pluck('name', 'id')->toArray())
                                ->placeholder('Seleccione su estado')
                                ->required()
                                ->reactive(),

                            Select::make('data.municipio')
                                ->label('Municipio')
                                ->options(fn() => $this->municipalities)
                                ->placeholder('Seleccione su municipio')
                                ->required()
                                ->reactive(),

                            TextInput::make('data.calle')
                                ->label('Calle')
                                ->placeholder('Ingrese su calle')
                                ->required(),

                            Select::make('data.colonia')
                                ->label('Colonia')
                                ->options(fn() => $this->neighborhoods)
                                ->placeholder('Seleccione su colonia')
                                ->required(),
                        ]),
                    ]),
            ])->submitAction(new HtmlString("<button class='btn btn-secondary'>Enviar</button>"))
                ->cancelAction(new HtmlString("<button class='btn btn-primary'>Cancelar</button>"))
        ]);
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
