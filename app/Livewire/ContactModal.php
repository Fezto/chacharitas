<?php

namespace App\Livewire;

use App\Livewire\Forms\ContactForm;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class ContactModal extends Component
{
    public ContactForm $form;

    /**
     * @throws ValidationException
     */
    #[NoReturn] public function save(){
        $this->form->store();
        dd("pepepe");
    }

    public function render(): View
    {
        return view('livewire.contact-modal');
    }
}
