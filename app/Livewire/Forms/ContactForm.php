<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    #[Validate('required')]
    public string $name;

    #[Validate('required')]
    public string $email;

    #[Validate('required')]
    public string $title;

    #[Validate('required|min:10')]
    public string $message;

    /**
     * @throws ValidationException
     */
    #[NoReturn] public function store(): void
    {
        $this->validate();
        echo 'Pepe';
    }

}
