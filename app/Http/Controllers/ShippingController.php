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
        // --- 2.1) Address From: tomamos la dirección del vendedor de la BD
        $userAddr = $product->user->address;
        $hood = $userAddr->neighborhood;
        $muni = $hood->municipality;
        $state = $muni->state;
        $country = $state->country; // en tu dump sólo tienes México

        $from = Shippo_Address::create([
            'name' => $product->user->name,
            'street1' => $userAddr->street . ' ' . $userAddr->street_number,
            'city' => $muni->name,
            'state' => $state->name,
            'zip' => str_pad($hood->postal_code, 5, '0', STR_PAD_LEFT),
            'country' => strtoupper($country->name) === 'MÉXICO' ? 'MX' : $country->code ?? 'MX',
            'phone' => $product->user->phone_number,
            'email' => $product->user->email,
        ]);

        // --- 2.2) Address To: tomamos del formulario y forzamos MX
        $to = Shippo_Address::create(array_merge(
            $request->input('to'),
            ['country' => 'MX']
        ));

        // --- 2.3) Shipment: direcciones + paquete
        $shipment = Shippo_Shipment::create([
            'address_from' => $from['object_id'],
            'address_to' => $to['object_id'],
            'parcels' => $request->input('parcels'),
            'async' => false,
        ]);

        // --- 2.4) Tarifas
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


