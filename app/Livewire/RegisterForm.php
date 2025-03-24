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
        if (empty($value)) return;

        // Limpiar caché previa si es necesario
        Cache::forget("municipalities_{$value}");

        $this->municipalities = $this->getCachedMunicipalities($value);
        $this->data['municipality_id'] = null;
        $this->neighborhoods = [];
        $this->data['neighborhood_id'] = null;
    }

    public function updatedDataMunicipalityId($value)
    {
        if (empty($value)) return;

        // Limpiar caché previa si es necesario
        Cache::forget("neighborhoods_{$value}");

        $this->neighborhoods = $this->getCachedNeighborhoods($value);
        $this->data['neighborhood_id'] = null;
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
        // Cargar solo estados inicialmente
        Cache::remember('states', 3600, function () {
            return State::orderBy('name')->pluck('name', 'id')->toArray();
        });

        // Eliminar caché de municipios y colonias (los cargaremos bajo demanda)
        Cache::forget('municipalities');
        Cache::forget('neighborhoods');
    }

    private function getCachedStates(): array
    {
        return Cache::remember('states', 3600, function () {
            return State::orderBy('name')->pluck('name', 'id')->toArray();
        });
    }

    private function getCachedMunicipalities($stateId): array
    {
        return Cache::remember("municipalities_{$stateId}", 3600, function () use ($stateId) {
            return Municipality::where('state_id', $stateId)
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    private function getCachedNeighborhoods($municipalityId): array
    {
        return Cache::remember("neighborhoods_{$municipalityId}", 3600, function () use ($municipalityId) {
            return Neighborhood::where('municipality_id', $municipalityId)
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    private function searchStates(string $search): array
    {
        return State::where('name', 'like', "{$search}%")
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    private function searchMunicipalities(string $search): array
    {
        $stateId = $this->data['state_id'] ?? null;

        return Municipality::when($stateId, fn($query) => $query->where('state_id', $stateId))
            ->where('name', 'like', "{$search}%")
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    private function searchNeighborhoods(string $search): array
    {
        $municipalityId = $this->data['municipality_id'] ?? null;

        return Neighborhood::when($municipalityId, fn($query) => $query->where('municipality_id', $municipalityId))
            ->where('name', 'like', "{$search}%")
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function cancel() {
        return redirect()->route('welcome.index'); // O `redirect('/')` para ir a la raíz
    }

}
