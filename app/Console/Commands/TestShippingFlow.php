<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use App\Services\FedExShippingService;
use Illuminate\Console\Command;
use Exception;

class TestShippingFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipping:test-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the complete shipping flow';

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
        $this->info('🚚 Probando flujo completo de envío...');
        
        try {
            // Obtener un producto y usuario de prueba
            $product = Product::with('user.address.neighborhood.municipality.state')->first();
            
            if (!$product) {
                $this->error('❌ No hay productos para probar');
                return 1;
            }

            $this->line('📦 Producto: ' . $product->name);
            $this->line('👤 Vendedor: ' . $product->user->name);

            // Datos de prueba para el envío
            $shipmentData = [
                'sender' => [
                    'name' => $product->user->name . ' ' . $product->user->last_name,
                    'email' => $product->user->email,
                    'phone' => $product->user->phone_number ?? '5555555555',
                    'company' => 'Chacharitas',
                    'street' => 'Av Insurgentes Sur 1000',
                    'city' => 'Ciudad de Mexico',
                    'state' => 'CMX',
                    'postal_code' => '03100',
                    'country' => 'MX'
                ],
                'recipient' => [
                    'name' => 'Cliente Prueba',
                    'email' => 'cliente@test.com',
                    'phone' => '5555554321',
                    'street' => 'Av Lopez Mateos 2000',
                    'city' => 'Guadalajara',
                    'state' => 'JAL',
                    'postal_code' => '44160',
                    'country' => 'MX'
                ],
                'weight' => 1.0,
                'dimensions' => [
                    'length' => 20,
                    'width' => 15,
                    'height' => 10
                ],
                'service_type' => 'FEDEX_GROUND'
            ];

            $this->line('');
            $this->info('📋 Probando cotización...');
            
            $quoteData = [
                'sender' => [
                    'postal_code' => '03100',
                    'country' => 'MX'
                ],
                'recipient' => [
                    'postal_code' => '44160',
                    'country' => 'MX'
                ],
                'weight' => 1.0
            ];

            $rates = $this->fedexService->getRateQuote($quoteData);
            
            $this->info('✅ Cotización exitosa!');
            $this->line('📊 Opciones encontradas: ' . count($rates['rates']));
            
            if (isset($rates['estimated']) && $rates['estimated']) {
                $this->warn('⚠️ Usando precios estimados (API de cotización no disponible)');
            }

            foreach (array_slice($rates['rates'], 0, 2) as $rate) {
                $serviceName = $rate['serviceName'] ?? $rate['serviceType'] ?? 'Servicio';
                $cost = $rate['ratedShipmentDetails'][0]['totalNetCharge'] ?? 'N/A';
                $currency = $rate['ratedShipmentDetails'][0]['currency'] ?? 'MXN';
                $this->line("  • $serviceName: $cost $currency");
            }

            $this->line('');
            $this->info('🏷️ Probando creación de guía...');
            
            $shipment = $this->fedexService->createShipment($shipmentData);
            
            $this->info('✅ Guía creada exitosamente!');
            $this->line('📍 Tracking: ' . ($shipment['tracking_number'] ?? 'N/A'));
            $this->line('💰 Costo: ' . ($shipment['total_cost'] ?? 'N/A') . ' ' . ($shipment['currency'] ?? 'USD'));
            $this->line('🔗 Label URL: ' . ($shipment['label_url'] ? 'Disponible' : 'No disponible'));

            $this->line('');
            $this->info('🎉 ¡Flujo de envío completado exitosamente!');
            
            return 0;

        } catch (Exception $e) {
            $this->line('');
            $this->error('❌ Error en el flujo: ' . $e->getMessage());
            return 1;
        }
    }
}
