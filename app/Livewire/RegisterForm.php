<?php

namespace App\Livewire;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Neighborhood;
use App\Models\State;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
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
        $this->loadCachedData();
    }


    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Wizard\Step::make('Información Personal')
                    ->completedIcon('heroicon-m-hand-thumb-up')
                    ->icon('heroicon-m-user')
                    ->description('Cuéntanos sobre ti')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            TextInput::make('data.name')
                                ->label('Nombre')
                                ->placeholder('Ingrese su nombre')
                                ->required(),

                            TextInput::make('data.last_name')
                                ->label('Apellido Paterno')
                                ->placeholder('Ingrese su apellido paterno')
                                ->required(),

                            TextInput::make('data.second_last_name')
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
                                ->minLength(8)
                                ->revealable()
                                ->helperText('Debe contener por lo menos 8 carácteres')
                                ->required(),

                            TextInput::make('data.password_confirmation')
                                ->label('Confirmar Contraseña')
                                ->password()
                                ->placeholder('Confirme su contraseña')
                                ->same('data.password')
                                ->revealable()
                                ->required(),
                        ]),
                    ]),
                Wizard\Step::make('Dirección')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(3)->schema([
                            TextInput::make('data.postal_code')
                                ->label('Código postal')
                                ->placeholder('Ej: 76902')
                                ->regex('/^\d+$/')
                                ->required()
                                ->length(5)
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    if (strlen($state) === 5) {
                                        $this->searchByPostalCode($state, $set);
                                    }
                                }),

                            TextInput::make('data.state_name')
                                ->label('Estado')
                                ->disabled()
                                ->dehydrated(false)
                                ->placeholder('Se autocompleta'),

                            TextInput::make('data.municipality_name')
                                ->label('Municipio')
                                ->disabled()
                                ->dehydrated(false)
                                ->placeholder('Se autocompleta'),
                        ]),

                        \Filament\Forms\Components\Grid::make(1)->schema([
                            Select::make('data.neighborhood_id')
                                ->label('Colonia')
                                ->options(fn() => $this->neighborhoods)
                                ->searchable()
                                ->placeholder('Primero ingrese el código postal')
                                ->required()
                                ->disabled(fn() => empty($this->neighborhoods)),
                        ]),

                        \Filament\Forms\Components\Grid::make(1)->schema([
                            TextInput::make('data.street')
                                ->label('Calle')
                                ->placeholder('Ingrese su calle')
                                ->required(),
                        ]),

                        \Filament\Forms\Components\Grid::make(2)->schema([
                            TextInput::make('data.street_number')
                                ->label('Número exterior')
                                ->placeholder('Ingrese su número exterior')
                                ->regex('/^\d+$/')
                                ->required(),

                            TextInput::make('data.unit_number')
                                ->label('Número interior')
                                ->placeholder('Ingrese su número interior')
                                ->regex('/^\d+$/'),
                        ]),
                    ]),
            ])->submitAction(new HtmlString("<button class='btn btn-secondary'>Enviar</button>"))
                ->cancelAction(new HtmlString("<button type='button' wire:click='cancel' class='btn btn-primary'>Cancelar</button>"))
                ->nextAction(fn(Action $action) => $action->label('Siguiente')->color('secondary'))
                ->previousAction(fn(Action $action) => $action->label('Regresar')->color('primary')),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function submit()
    {
        $this->validate();

        try {
            $user = app(CreateNewUser::class)->create($this->data);
            event(new Registered($user));
            Auth::login($user);
            session()->flash('status', 'Verification link sent!');
            return redirect(route('verification.notice')); // O la ruta configurada

        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al registrar el usuario.');
        }
    }


    public function render(): View
    {
        return view('livewire.register-form');
    }


    // * Funciones de apoyo

    private function loadCachedData(): void
    {
        // Cargar solo estados inicialmente
        Cache::remember('states', 3600, function () {
            return State::orderBy('name')->pluck('name', 'id')->toArray();
        });

        // Eliminar caché de municipios y colonias (los cargaremos bajo demanda)
        Cache::forget('municipalities');
        Cache::forget('neighborhoods');
    }

    public function cancel()
    {
        return redirect()->route('welcome.index'); // O `redirect('/')` para ir a la raíz
    }

    private function searchByPostalCode(string $postalCode, $set): void
    {
        $neighborhood = Neighborhood::where('postal_code', $postalCode)
            ->with(['municipality.state'])
            ->first();

        if (!$neighborhood) {
            $this->addError('data.postal_code', 'Código postal no encontrado');
            $this->neighborhoods = [];
            return;
        }

        // Obtener todas las colonias para el CP
        $this->neighborhoods = Neighborhood::where('postal_code', $postalCode)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        // Actualizar los campos derivados
        $set('data.state_id', $neighborhood->municipality->state_id);
        $set('data.municipality_id', $neighborhood->municipality_id);
        $set('data.state_name', $neighborhood->municipality->state->name);
        $set('data.municipality_name', $neighborhood->municipality->name);

        // Forzar actualización del componente
        $this->form->fill($this->data);
    }

}
