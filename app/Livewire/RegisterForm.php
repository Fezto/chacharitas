<?php

namespace App\Livewire;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Address;
use App\Models\Municipality;
use App\Models\Neighborhood;
use App\Models\State;
use App\Models\User;
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

    public function updatedDataStateId($value)
    {
        $this->municipalities = $this->getCachedMunicipalities($value);
        $this->data['municipality_id'] = null; // Cambiado a municipality_id
        $this->neighborhoods = [];
        $this->data['neighborhood_id'] = null; // Cambiado a neighborhood_id
    }

    public function updatedDataMunicipalityId($value)
    {
        $this->neighborhoods = $this->getCachedNeighborhoods($value);
        $this->data['neighborhood_id'] = null; // Cambiado a neighborhood_id
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
                    ->completedIcon('heroicon-m-hand-thumb-up')
                    ->icon('heroicon-m-home')
                    ->description('¿Donde te encuentras?')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            Select::make('data.state_id')
                                ->label('Estado')
                                ->options($this->getCachedStates())
                                ->searchable()
                                ->placeholder('Seleccione su estado')
                                ->getSearchResultsUsing(fn(string $search): array => $this->searchStates($search))
                                ->required()
                                ->reactive(),

                            Select::make('data.municipality_id')
                                ->label('Municipio')
                                ->options(fn() => $this->municipalities)
                                ->searchable()
                                ->placeholder('Seleccione su municipio')
                                ->getSearchResultsUsing(fn(string $search): array => $this->searchMunicipalities($search))
                                ->required()
                                ->reactive(),

                            Select::make('data.neighborhood_id')
                                ->label('Colonia')
                                ->options(fn() => $this->neighborhoods)
                                ->searchable()
                                ->placeholder('Seleccione su colonia')
                                ->getSearchResultsUsing(fn(string $search): array => $this->searchNeighborhoods($search))
                                ->required(),

                            TextInput::make('data.street')
                                ->label('Calle')
                                ->placeholder('Ingrese su calle')
                                ->required()
                        ]),
                        \Filament\Forms\Components\Grid::make(3)->schema([
                            TextInput::make('data.postal_code')
                                ->label('Código postal')
                                ->placeholder('Ingrese su código postal')
                                ->regex('/^\d+$/')
                                ->required()
                                ->length(5),

                            TextInput::make('data.street_number')
                                ->label('Número exterior')
                                ->placeholder('Ingrese su número exterior')
                                ->regex('/^\d+$/')
                                ->required(),

                            TextInput::make('data.unit_number')
                                ->label('Número exterior')
                                ->placeholder('Ingrese su número interior')
                                ->regex('/^\d+$/')
                        ]),

                    ]),
            ])->submitAction(new HtmlString("<button class='btn btn-secondary'>Enviar</button>"))
                ->cancelAction(new HtmlString("<button type='button' wire:click='cancel' class='btn btn-primary'>Cancelar</button>"))
            ->nextAction(fn (Action $action) => $action->label('Siguiente')->color('secondary'))
            ->previousAction(fn (Action $action) => $action->label('Regresar')->color('primary')),
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
        Cache::rememberForever('states', function () {
            return State::orderBy('name')->pluck('name', 'id')->toArray();
        });

        Cache::rememberForever('municipalities', function () {
            return Municipality::orderBy('name')
                ->select(['id', 'name', 'state_id']) // Optimizando la selección de columnas
                ->get()
                ->groupBy('state_id')
                ->map(fn($group) => $group->pluck('name', 'id')->toArray())
                ->toArray();
        });

        Cache::rememberForever('neighborhoods', function () {
            return Neighborhood::orderBy('name')
                ->select(['id', 'name', 'municipality_id'])
                ->get()
                ->groupBy('municipality_id')
                ->map(fn($group) => $group->pluck('name', 'id')->toArray())
                ->toArray();
        });
    }

    private function getCachedStates(): array
    {
        return Cache::get('states', []);
    }

    private function getCachedMunicipalities($stateId): array
    {
        $municipalities = Cache::get('municipalities', []);
        return $municipalities[$stateId] ?? [];
    }

    private function getCachedNeighborhoods($municipalityId): array
    {
        $neighborhoods = Cache::get('neighborhoods', []);
        return $neighborhoods[$municipalityId] ?? [];
    }

    private function searchStates(string $search): array
    {
        $states = $this->getCachedStates();
        $search = preg_quote($search, '/');
        $pattern = "/^{$search}/i";

        return array_filter($states, fn($name) => preg_match($pattern, $name));
    }

    private function searchMunicipalities(string $search): array
    {
        $municipalities = $this->municipalities;
        $search = preg_quote($search, '/');
        $pattern = "/^{$search}/i";

        return array_filter($municipalities, fn($name) => preg_match($pattern, $name));
    }

    private function searchNeighborhoods(string $search): array
    {
        $neighborhoods = $this->neighborhoods;
        $search = preg_quote($search, '/');
        $pattern = "/^{$search}/i";

        return array_filter($neighborhoods, fn($name) => preg_match($pattern, $name));
    }

    public function cancel() {
        return redirect()->route('welcome.index'); // O `redirect('/')` para ir a la raíz
    }

}
