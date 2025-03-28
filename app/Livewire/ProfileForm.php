<?php

namespace App\Livewire;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfileForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->data = $user->only([
            'name',
            'last_name',
            'second_last_name',
            'email',
            'phone_number',
            'photo',
        ]);

        // Prellenar el formulario con los datos actuales
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('data.name')
                            ->label('Nombre')
                            ->required(),

                        TextInput::make('data.last_name')
                            ->label('Apellido Paterno')
                            ->required(),

                        TextInput::make('data.second_last_name')
                            ->label('Apellido Materno')
                            ->required(),

                        TextInput::make('data.email')
                            ->label('Correo electrónico')
                            ->email()
                            ->required(),

                        TextInput::make('data.phone_number')
                            ->label('Teléfono')
                            ->tel()
                            ->nullable(),

                        TextInput::make('data.password')
                            ->label('Nueva contraseña')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->nullable(),

                        TextInput::make('data.password_confirmation')
                            ->label('Confirmar contraseña')
                            ->password()
                            ->dehydrated(false)
                            ->same('data.password')
                            ->nullable(),

                        FileUpload::make('data.photo')
                            ->label('Foto de perfil')
                            ->image()
                            ->directory('users')
                            ->disk('public')
                            ->maxSize(1024)
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth(200)
                            ->imageResizeTargetHeight(200)
                            // Mostrar la imagen actual si existe
                            ->default(fn () => Auth::user()->photo ? [Auth::user()->photo] : [])
                            ->nullable(),

                        Actions::make([
                            Action::make('Guardar')
                                ->label('Guardar cambios')
                                ->color('primary')
                                ->action(function () {
                                    $this->save();
                                }),
                        ])->fullWidth(),
                    ])
            ]);
    }

    public function save(): void
    {
        $formData = $this->form->getState()['data'];
        $user = Auth::user();

        $user->update([
            'name' => $formData['name'],
            'email' => $formData['email'],
            'password' => $formData['password'] ?? $user->password,
            'photo' => $formData['photo'] ?? $user->photo
        ]);

        session()->flash('success', 'Perfil actualizado correctamente.');
    }

    public function render(): View
    {
        return view('livewire.profile-form');
    }
}
