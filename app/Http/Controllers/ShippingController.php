<?php

namespace App\Http\Controllers;

use App\Mail\ShippingLabelMail;
use App\Models\Product;
use App\Providers\FedexServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ShippingController extends Controller
{
    public function __construct(protected FedexServiceProvider $fedex)
    {
    }


    /** 1) Muestra formulario para datos de destino */
    public function index(Product $product)
    {
        return view('shipping', compact('product'));
    }

    /** 2) Cotiza envío usando direcciones de DB + formulario */
    public function quote(Request $request, Product $product)
    {
        $from = ['postalCode' => '01619', 'countryCode' => 'MX'];
        $to = ['postalCode' => $request->input('to_zip'), 'countryCode' => 'MX'];


        $rates = $this->fedex->getRates($from, $to, $request->input('weight'));

        return view('shipping', compact('product', 'rates'));
    }



    /** 3) Compra la etiqueta y redirige al PDF */
    // app/Http/Controllers/ShippingController.php

    public function purchase(Request $request, Product $product)
    {
        $txId = "624deea6-b709-470c-8c39-4b5511281492";

        $payload = [
            'mergeLabelDocOption'  => 'LABELS_AND_DOCS',
            'labelResponseOptions' => 'URL_ONLY',
            'shipAction'           => 'CONFIRM',
            'processingOptionType' => 'SYNCHRONOUS_ONLY',

            'accountNumber' => [
                'value' => config('services.fedex.account_number'),
            ],

            'requestedShipment' => [
                'shipper' => [
                    'contact' => [
                        'personName'  => config('app.name'),
                        'phoneNumber' => "5551234567",
                    ],
                    'address' => [
                        'streetLines'         => ['10 FedEx Parkway'],
                        'city'                => 'Memphis',
                        'stateOrProvinceCode' => 'TN',
                        'postalCode'          => '38116',
                        'countryCode'         => 'US',
                    ],
                ],

                'recipients' => [[
                    'contact' => [
                        'personName'  => 'Ayrton',
                        'phoneNumber' => '4421941607',
                    ],
                    'address' => [
                        'streetLines'         => ['1600 Amphitheatre Parkway'],
                        'city'                => 'Mountain View',
                        'stateOrProvinceCode' => 'CA',
                        'postalCode'          => '94043', // <- ahora sí coincide con CA
                        'countryCode'         => 'US',
                    ],
                ]],


                'pickupType'    => 'DROPOFF_AT_FEDEX_LOCATION',
                'serviceType'   => 'FEDEX_GROUND',
                'packagingType' => 'YOUR_PACKAGING',

                'shippingChargesPayment' => [
                    'paymentType' => 'SENDER',
                    'payor'       => [
                        'responsibleParty' => [
                            'accountNumber' => [
                                'value' => config('services.fedex.account_number'),
                            ],
                        ],
                    ],
                ],

                'labelSpecification' => [
                    'labelFormatType' => 'COMMON2D',
                    'imageType'       => 'PDF',
                    'labelStockType'  => 'PAPER_4X6',
                ],

                'requestedPackageLineItems' => [[
                    'sequenceNumber' => 1,
                    'weight' => [
                        'units' => 'KG',
                        'value' => $request->input('weight', 1),
                    ],
                ]],
            ],
        ];


        // Para depurar: mira el payload antes de enviar
        \Log::debug('FedEx payload', $payload);

        $labelUrl = $this->fedex->createShipment($payload, $txId);

        // Lo enviamos por correo al vendedor
        Mail::to($product->user->email)
            ->queue(new ShippingLabelMail($labelUrl, $product));

        return redirect()->route('shop.index')
            ->with('status', '¡Envío generado! El vendedor recibirá la guía por correo.');
    }


    public function test()
    {

        $url = env('FEDEX_BASE_URL') . '/rate/v1/rates/quotes';

        // Autenticación OAuth2
        $authResponse = Http::asForm()->post(env('FEDEX_BASE_URL') . '/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => env('FEDEX_KEY'),
            'client_secret' => env('FEDEX_SECRET'),
        ]);

        if (!$authResponse->ok()) {
            return response()->json(['error' => 'No se pudo autenticar con FedEx', 'details' => $authResponse->json()], 500);
        }

        $token = $authResponse->json()['access_token'];

        // Ejemplo básico de envío
        $rateResponse = Http::withToken($token)
            ->post($url, [
                "accountNumber" => [
                    "value" => "510087000" // Este es un número de prueba que FedEx acepta
                ],
                "requestedShipment" => [
                    "shipper" => [
                        "address" => [
                            "postalCode" => "01000",
                            "countryCode" => "MX"
                        ]
                    ],
                    "recipient" => [
                        "address" => [
                            "postalCode" => "64000",
                            "countryCode" => "MX"
                        ]
                    ],
                    "pickupType" => "DROPOFF_AT_FEDEX_LOCATION",
                    "rateRequestType" => ["ACCOUNT"],
                    "requestedPackageLineItems" => [[
                        "weight" => [
                            "units" => "KG",
                            "value" => 1
                        ]
                    ]]
                ]
            ]);

        dd($rateResponse->json());
    }
}


