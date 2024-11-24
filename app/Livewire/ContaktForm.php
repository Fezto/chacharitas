<?php
namespace App\Livewire;

use App\Mail\ContactMail;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
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
                // Sección única que agrupa todo el formulario
                Section::make()
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
                            ->required()
                            ->minLength(5),

                        Actions::make([
                            Action::make('Enviar')
                                ->label('Enviar')
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
        // Lógica para procesar el formulario, como enviar un correo o guardar en la base de datos
        $form_data = $this->form->getState();

        // Enviar correo
        Mail::to(env('MAIL_USERNAME'))->send(new ContactMail($form_data['data']));

        // Mostrar mensaje de éxito
        session()->flash('success', 'El mensaje ha sido enviado correctamente.');
    }

    public function render(): View
    {
        return view('livewire.contakt-form');
    }
}
