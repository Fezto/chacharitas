<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email?}';
    protected $description = 'Test email configuration';

    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        try {
            Mail::raw('Este es un correo de prueba para verificar la configuración de Mailgun.', function ($message) use ($email) {
                $message->to($email)
                       ->subject('Prueba de configuración de correo');
            });
            
            $this->info("Correo de prueba enviado exitosamente a: {$email}");
        } catch (\Exception $e) {
            $this->error("Error al enviar correo: " . $e->getMessage());
        }
    }
}
