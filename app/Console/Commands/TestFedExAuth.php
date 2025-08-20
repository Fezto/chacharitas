<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Exception;

class TestFedExAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fedex:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test only FedEx OAuth2 authentication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔑 Probando solo autenticación OAuth2 con FedEx...');
        
        try {
            $baseUrl = config('services.fedex.base_url');
            $apiKey = config('services.fedex.key');
            $secretKey = config('services.fedex.secret');

            $this->line('Base URL: ' . $baseUrl);
            $this->line('API Key: ' . substr($apiKey, 0, 10) . '...');
            $this->line('Secret: ' . substr($secretKey, 0, 10) . '...');

            $response = Http::asForm()->post($baseUrl . '/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $apiKey,
                'client_secret' => $secretKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->info('✅ Autenticación OAuth2 exitosa!');
                $this->line('Token Type: ' . $data['token_type']);
                $this->line('Expires In: ' . $data['expires_in'] . ' segundos');
                $this->line('Scope: ' . $data['scope']);
                
                // Mostrar solo parte del token por seguridad
                $token = $data['access_token'];
                $this->line('Access Token: ' . substr($token, 0, 20) . '...');
                
                return 0;
            } else {
                $this->error('❌ Error en autenticación:');
                $this->line('Status: ' . $response->status());
                $this->line('Response: ' . $response->body());
                return 1;
            }

        } catch (Exception $e) {
            $this->error('❌ Excepción durante autenticación: ' . $e->getMessage());
            return 1;
        }
    }
}
