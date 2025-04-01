<?php


namespace App\Livewire;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
            'url',
        ]);

        // Prellenar el formulario con los datos actuales
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Grid::make(2) // Crea 2 columnas
                    ->schema([
                        Group::make() // Primera columna: Datos
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
                        ]),

                        Group::make() // Segunda columna: Foto de perfil
                        ->schema([
                            FileUpload::make('data.url')
                                ->label('Foto de perfil')
                                ->image()
                                ->disk('profile_images')
                                ->maxSize(1024)
                                ->imageCropAspectRatio('1:1')
                                ->imageEditor()
                                ->imageEditorMode(1)
                                ->circleCropper()
                                ->imageResizeTargetWidth(200)
                                ->imageResizeTargetHeight(200)
                        ]),

                        Actions::make([
                            Action::make('Guardar')
                                ->label('Guardar cambios')
                                ->color('primary')
                                ->action(fn() => $this->save()),
                        ])->fullWidth()->columnSpanFull(),
                    ])
                ])->extraAttributes(['class' => 'max-w-none']),

        ]);
    }


    public function save(): void
    {
        $formData = $this->form->getState()['data'];
        $user = Auth::user();

        $user->update([
            'name' => $formData['name'],
            'last_name' => $formData['last_name'],
            'second_last_name' => $formData['second_last_name'],
            'email' => $formData['email'],
            'phone_number' => $formData['phone_number'],
            'url' => $formData['url'] ?? $user->url,
        ]);

        session()->flash('success', 'Perfil actualizado correctamente.');
    }

    public function render(): View
    {
        return view('livewire.profile-form');
    }
}

