<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginForm extends Component implements HasForms
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
                Wizard\Step::make('Información de usuario')->schema([
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
                        ->helperText('Debe contener por lo menos 8 caracteres')
                        ->required(),
                ]),
            ])->submitAction(new HtmlString("<button class='btn btn-secondary'>Enviar</button>"))
                ->cancelAction(new HtmlString("<button type='button' wire:click='cancel' class='btn btn-primary'>Cancelar</button>")),

        ]);
    }

    /**
     * @throws ValidationException
     */
    public function submit()
    {
        $this->validate();

        $credentials = [
            'email' => $this->data['email'],
            'password' => $this->data['password']
        ];

        if (Auth::attempt($credentials)) {
            // Si las credenciales son correctas, redirigir al usuario
            return redirect()->intended('/'); // Redirige a la página deseada
        }

        // Si el inicio de sesión falla, lanzar un flash con el mensaje de error
        session()->flash('error', 'Las credenciales proporcionadas son incorrectas.');

        // Redirigir de nuevo a la página de inicio de sesión o la misma página
        return redirect()->back();

    }

    public function render(): View
    {
        return view('livewire.login-form');
    }

    public function cancel() {
        return redirect()->route('welcome.index'); // O `redirect('/')` para ir a la raíz
    }
}
