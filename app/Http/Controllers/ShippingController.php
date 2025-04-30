<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Shippo;
use \Shippo_Address;
use \Shippo_Shipment;
use \Shippo_Transaction;

class ShippingController extends Controller
{
    public function __construct()
    {
        // Ajusta para leer de services.php
        Shippo::setApiKey(config('services.shippo.api_key'));
    }

    /** 1) Muestra formulario para datos de destino */
    public function index(Product $product)
    {
        return view('shipping', compact('product'));
    }

    /** 2) Cotiza envío usando direcciones de DB + formulario */
    public function quote(Request $request, Product $product)
    {
        // 1. Dirección FROM (ubicación drop-off)
        $from = Shippo_Address::create([
            'name' => 'Chacharitas Dropoff',
            'street1' => 'Sucursal DHL México',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'zip' => '01000',
            'country' => 'MX',
            'phone' => '5555555555',
            'email' => 'dropoff@chacharitas.mx',
        ]);

        // 2. Dirección TO: Cliente destino
        $to = Shippo_Address::create(array_merge(
            $request->input('to'),
            ['country' => 'MX']
        ));

        // 3. Crear el envío con el carrier y el servicelevel_token adecuado (drop-off)
        $shipment = Shippo_Shipment::create([
            'address_from' => $from['object_id'],
            'address_to' => $to['object_id'],
            'parcels' => $request->input('parcels'),
            'carrier_accounts' => [config('services.shippo.carrier_dhl_account_id')], // Usar el carrier_account_id de DHL
            'servicelevel_token' => 'dhl_mexico_dropoff', // El token para drop-off de DHL
            'extra' => [
                'qr_code_requested' => true, // Solicitar código QR para el drop-off
            ],
            'metadata' => 'Producto ID ' . $product->id,
            'async' => false,
        ]);

        // 4. Obtener las tarifas de envío
        $rates = $shipment['rates'];

        return view('shipping', [
            'product' => $product,
            'options' => $rates,
            'from_id' => $from['object_id'],
            'to_id' => $to['object_id'],
            'shipment_id' => $shipment['object_id'],
        ]);
    }



    /** 3) Compra la etiqueta y redirige al PDF */
    public function purchase(Request $request, Product $product)
    {
        $transaction = Shippo_Transaction::create([
            'rate' => $request->input('rate_id'),
            'label_file_type' => 'PDF',
            'async' => false,
        ]);

        // Si tu carrier soporta QR, aquí puedes mostrar la URL
        if (!empty($transaction['qr_code_url'])) {
            return redirect()->away($transaction['qr_code_url']);
        }

        return redirect()->away($transaction['label_url']);
    }

    public function test()
    {

        Shippo::setApiKey(config('services.shippo.api_key'));

        $fromAddress = Shippo_Address::create([
            "name"     => "Shawn Ippotle",
            "company"  => "Shippo",
            "street1"  => "215 Clayton St.",
            "city"     => "San Francisco",
            "state"    => "CA",
            "zip"      => "94117",
            "country"  => "US",
            "phone"    => "+1 555 341 9393",
            "email"    => "shippotle@shippo.com"
        ]);

        dd($fromAddress);
    }
}


