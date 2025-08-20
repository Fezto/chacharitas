<?php

namespace App\Console\Commands;

use App\Services\FedExShippingService;
use Illuminate\Console\Command;
use Exception;

class TestFedExConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fedex:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test FedEx API connection and configuration';

    protected FedExShippingService $fedexService;

    public function __construct(FedExShippingService $fedexService)
    {
        parent::__construct();
        $this->fedexService = $fedexService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚚 Probando conexión con FedEx API...');
        
        // Verificar configuración
        $this->line('');
        $this->info('📋 Verificando configuración:');
        $this->line('Base URL: ' . config('services.fedex.base_url'));
        $this->line('API Key: ' . (config('services.fedex.key') ? '✅ Configurada' : '❌ No configurada'));
        $this->line('Secret: ' . (config('services.fedex.secret') ? '✅ Configurada' : '❌ No configurada'));
        $this->line('Account Number: ' . (config('services.fedex.account_number') ? '✅ Configurada' : '❌ No configurada'));

        if (!config('services.fedex.key') || !config('services.fedex.secret')) {
            $this->error('❌ Faltan configuraciones de FedEx en el archivo .env');
            return 1;
        }

        $this->line('');
        $this->info('🔑 Probando autenticación OAuth2...');
        
        try {
            // Test de cotización simple con códigos postales válidos de México
            $testData = [
                'sender' => [
                    'postal_code' => '03100', // Código postal válido de CDMX
                    'country' => 'MX'
                ],
                'recipient' => [
                    'postal_code' => '44160', // Código postal válido de Guadalajara
                    'country' => 'MX'
                ],
                'weight' => 0.5 // Peso más realista en KG
            ];

            $rates = $this->fedexService->getRateQuote($testData);
            
            $this->line('');
            $this->info('✅ Conexión exitosa con FedEx API!');
            $this->line('📦 Se encontraron ' . count($rates['rates']) . ' opciones de envío disponibles');
            
            if (!empty($rates['rates'])) {
                $this->line('');
                $this->info('💰 Algunas opciones de envío:');
                foreach (array_slice($rates['rates'], 0, 3) as $rate) {
                    $serviceName = $rate['serviceName'] ?? 'Servicio desconocido';
                    $totalCharge = $rate['ratedShipmentDetails'][0]['totalNetCharge'] ?? 'N/A';
                    $currency = $rate['ratedShipmentDetails'][0]['currency'] ?? 'USD';
                    $this->line("  • {$serviceName}: {$totalCharge} {$currency}");
                }
            }

            return 0;

        } catch (Exception $e) {
            $this->line('');
            $this->error('❌ Error al conectar con FedEx:');
            $this->error($e->getMessage());
            
            $this->line('');
            $this->info('🔧 Posibles soluciones:');
            $this->line('1. Verifica tus credenciales de FedEx en el archivo .env');
            $this->line('2. Asegúrate de estar usando las credenciales correctas (sandbox vs production)');
            $this->line('3. Verifica que tu cuenta FedEx esté activa');
            $this->line('4. Ejecuta: php artisan config:clear');
            
            return 1;
        }
    }
}
