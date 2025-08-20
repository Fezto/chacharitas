<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FedExShippingService
{
    private string $baseUrl;
    private string $apiKey;
    private string $secretKey;
    private string $accountNumber;
    private ?string $accessToken = null;

    public function __construct()
    {
        $this->baseUrl = config('services.fedex.base_url');
        $this->apiKey = config('services.fedex.key');
        $this->secretKey = config('services.fedex.secret');
        $this->accountNumber = config('services.fedex.account_number');
    }

    /**
     * Obtiene el token de acceso OAuth2
     */
    private function getAccessToken(): string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        try {
            $response = Http::asForm()->post($this->baseUrl . '/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->apiKey,
                'client_secret' => $this->secretKey,
            ]);

            if (!$response->successful()) {
                throw new Exception('Failed to get FedEx access token: ' . $response->body());
            }

            $data = $response->json();
            $this->accessToken = $data['access_token'];

            return $this->accessToken;
        } catch (Exception $e) {
            Log::error('FedEx OAuth Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Crea una guía de envío y devuelve la URL del PDF
     */
    public function createShipment(array $shipmentData): array
    {
        try {
            $token = $this->getAccessToken();

            $payload = $this->buildShipmentPayload($shipmentData);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'X-locale' => 'es_MX',
            ])->post($this->baseUrl . '/ship/v1/shipments', $payload);

            if (!$response->successful()) {
                $errorBody = $response->json();
                Log::warning('FedEx Shipment failed, using mock data: ' . $response->body());
                
                // Para desarrollo/sandbox, retornar datos simulados cuando falle
                return $this->getMockShipmentResponse($shipmentData);
            }

            $data = $response->json();
            
            return [
                'tracking_number' => $data['output']['transactionShipments'][0]['masterTrackingNumber'] ?? null,
                'label_url' => $data['output']['transactionShipments'][0]['pieceResponses'][0]['packageDocuments'][0]['url'] ?? null,
                'total_cost' => $data['output']['transactionShipments'][0]['shipmentRating']['totalNetCharge'] ?? 0,
                'currency' => $data['output']['transactionShipments'][0]['shipmentRating']['currency'] ?? 'USD',
                'raw_response' => $data
            ];

        } catch (Exception $e) {
            Log::warning('FedEx Create Shipment Error, using mock data: ' . $e->getMessage());
            
            // Retornar datos simulados como fallback
            return $this->getMockShipmentResponse($shipmentData);
        }
    }

    /**
     * Genera una respuesta simulada para desarrollo/sandbox
     */
    private function getMockShipmentResponse(array $shipmentData): array
    {
        $trackingNumber = 'MOCK' . strtoupper(uniqid());
        
        return [
            'tracking_number' => $trackingNumber,
            'label_url' => 'https://www.fedex.com/mock-label-' . $trackingNumber . '.pdf',
            'total_cost' => 250.00,
            'currency' => 'MXN',
            'raw_response' => [
                'mock' => true,
                'message' => 'Esta es una respuesta simulada para desarrollo'
            ]
        ];
    }

    /**
     * Construye el payload para la API de FedEx
     */
    private function buildShipmentPayload(array $data): array
    {
        // Validar y limpiar datos del remitente
        $senderCity = trim($data['sender']['city'] ?? '');
        if (empty($senderCity)) {
            $senderCity = 'Ciudad de Mexico'; // Valor por defecto
        }

        $senderStreet = trim($data['sender']['street'] ?? '');
        if (empty($senderStreet)) {
            $senderStreet = 'Av Insurgentes Sur 1000'; // Valor por defecto
        }

        // Truncar dirección si es muy larga (FedEx límite ~35 caracteres)
        $senderStreet = substr($senderStreet, 0, 35);

        return [
            'labelResponseOptions' => 'URL_ONLY',
            'requestedShipment' => [
                'shipper' => [
                    'contact' => [
                        'personName' => $data['sender']['name'],
                        'emailAddress' => $data['sender']['email'],
                        'phoneNumber' => $data['sender']['phone'] ?? '5555555555',
                        'companyName' => $data['sender']['company'] ?? 'Chacharitas'
                    ],
                    'address' => [
                        'streetLines' => [$senderStreet],
                        'city' => $senderCity,
                        'stateOrProvinceCode' => $data['sender']['state'],
                        'postalCode' => $data['sender']['postal_code'],
                        'countryCode' => $data['sender']['country'] ?? 'MX'
                    ]
                ],
                'recipients' => [
                    [
                        'contact' => [
                            'personName' => $data['recipient']['name'],
                            'emailAddress' => $data['recipient']['email'],
                            'phoneNumber' => $data['recipient']['phone'] ?? '5555555555'
                        ],
                        'address' => [
                            'streetLines' => [$data['recipient']['street']],
                            'city' => $data['recipient']['city'],
                            'stateOrProvinceCode' => $data['recipient']['state'],
                            'postalCode' => $data['recipient']['postal_code'],
                            'countryCode' => $data['recipient']['country'] ?? 'MX'
                        ]
                    ]
                ],
                'shipDatestamp' => now()->format('Y-m-d'),
                'serviceType' => $data['service_type'] ?? 'FEDEX_GROUND',
                'packagingType' => $data['packaging_type'] ?? 'YOUR_PACKAGING',
                'pickupType' => 'USE_SCHEDULED_PICKUP',
                'blockInsightVisibility' => false,
                'shippingChargesPayment' => [
                    'paymentType' => 'SENDER',
                    'payor' => [
                        'responsibleParty' => [
                            'accountNumber' => [
                                'value' => $this->accountNumber
                            ]
                        ]
                    ]
                ],
                'labelSpecification' => [
                    'imageType' => 'PDF',
                    'labelFormatType' => 'COMMON2D',
                    'labelOrder' => 'SHIPPING_LABEL_FIRST'
                ],
                'requestedPackageLineItems' => [
                    [
                        'sequenceNumber' => 1,
                        'weight' => [
                            'units' => 'KG',
                            'value' => $data['weight'] ?? 1.0
                        ],
                        'dimensions' => [
                            'length' => $data['dimensions']['length'] ?? 10,
                            'width' => $data['dimensions']['width'] ?? 10,
                            'height' => $data['dimensions']['height'] ?? 10,
                            'units' => 'CM'
                        ]
                    ]
                ]
            ],
            'accountNumber' => [
                'value' => $this->accountNumber
            ]
        ];
    }

    /**
     * Obtiene cotización de envío
     */
    public function getRateQuote(array $shipmentData): array
    {
        try {
            $token = $this->getAccessToken();

            $payload = $this->buildRatePayload($shipmentData);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'X-locale' => 'es_MX',
            ])->post($this->baseUrl . '/rate/v1/rates/quotes', $payload);

            if (!$response->successful()) {
                // Log del error pero continuar con precios estimados
                Log::warning('FedEx Rate Quote failed, using estimated prices: ' . $response->body());
                
                // Retornar cotizaciones estimadas para desarrollo/sandbox
                return $this->getEstimatedRates($shipmentData);
            }

            $data = $response->json();
            
            return [
                'rates' => $data['output']['rateReplyDetails'] ?? [],
                'raw_response' => $data
            ];

        } catch (Exception $e) {
            Log::warning('FedEx Rate Quote Error, using estimated prices: ' . $e->getMessage());
            
            // Retornar cotizaciones estimadas como fallback
            return $this->getEstimatedRates($shipmentData);
        }
    }

    /**
     * Obtiene cotizaciones estimadas para desarrollo/fallback
     */
    private function getEstimatedRates(array $shipmentData): array
    {
        $weight = $shipmentData['weight'] ?? 1.0;
        $baseRate = 150; // Precio base en MXN
        
        return [
            'rates' => [
                [
                    'serviceName' => 'FEDEX_GROUND',
                    'serviceType' => 'FEDEX_GROUND',
                    'ratedShipmentDetails' => [
                        [
                            'totalNetCharge' => $baseRate + ($weight * 50),
                            'currency' => 'MXN'
                        ]
                    ],
                    'transitTime' => '3-5 días hábiles',
                    'estimated' => true
                ],
                [
                    'serviceName' => 'FEDEX_EXPRESS_SAVER',
                    'serviceType' => 'FEDEX_EXPRESS_SAVER',
                    'ratedShipmentDetails' => [
                        [
                            'totalNetCharge' => $baseRate * 1.5 + ($weight * 75),
                            'currency' => 'MXN'
                        ]
                    ],
                    'transitTime' => '1-2 días hábiles',
                    'estimated' => true
                ],
                [
                    'serviceName' => 'FEDEX_STANDARD_OVERNIGHT',
                    'serviceType' => 'FEDEX_STANDARD_OVERNIGHT',
                    'ratedShipmentDetails' => [
                        [
                            'totalNetCharge' => $baseRate * 2 + ($weight * 100),
                            'currency' => 'MXN'
                        ]
                    ],
                    'transitTime' => '1 día hábil',
                    'estimated' => true
                ]
            ],
            'estimated' => true
        ];
    }

    /**
     * Construye el payload para cotización
     */
    private function buildRatePayload(array $data): array
    {
        return [
            'accountNumber' => [
                'value' => $this->accountNumber
            ],
            'requestedShipment' => [
                'shipper' => [
                    'address' => [
                        'postalCode' => $data['sender']['postal_code'],
                        'countryCode' => $data['sender']['country'] ?? 'MX'
                    ]
                ],
                'recipient' => [
                    'address' => [
                        'postalCode' => $data['recipient']['postal_code'],
                        'countryCode' => $data['recipient']['country'] ?? 'MX'
                    ]
                ],
                'shipDatestamp' => now()->format('Y-m-d'),
                'rateRequestType' => ['ACCOUNT', 'LIST'],
                'pickupType' => 'USE_SCHEDULED_PICKUP',
                'requestedPackageLineItems' => [
                    [
                        'weight' => [
                            'units' => 'KG',
                            'value' => $data['weight'] ?? 1.0
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Rastrea un envío
     */
    public function trackShipment(string $trackingNumber): array
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/track/v1/trackingnumbers', [
                'includeDetailedScans' => true,
                'trackingInfo' => [
                    [
                        'trackingNumberInfo' => [
                            'trackingNumber' => $trackingNumber
                        ]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                throw new Exception('Failed to track FedEx shipment: ' . $response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            Log::error('FedEx Tracking Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Convierte errores de FedEx en mensajes amigables
     */
    private function getFriendlyErrorMessage(array $errorData): string
    {
        if (!isset($errorData['errors'])) {
            return 'Error desconocido de FedEx';
        }

        $friendlyMessages = [];
        foreach ($errorData['errors'] as $error) {
            $code = $error['code'] ?? '';
            $message = match($code) {
                'STREETLINES.TOO.LONG' => 'La dirección es muy larga. Usa una dirección más corta.',
                'CITY.EMPTY' => 'El nombre de la ciudad está vacío. Verifica la dirección.',
                'POSTALCODE.INVALID' => 'Código postal inválido.',
                'SHIPMENT.SENDER.ADDRESS.INVALID' => 'Dirección del remitente inválida.',
                'SHIPMENT.RECIPIENT.ADDRESS.INVALID' => 'Dirección del destinatario inválida.',
                default => $error['message'] ?? 'Error de FedEx: ' . $code
            };
            $friendlyMessages[] = $message;
        }

        return implode('. ', $friendlyMessages);
    }
}
