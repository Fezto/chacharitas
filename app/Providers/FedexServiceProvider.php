<?php
// app/Providers/SkydropxServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Http;

class FedexServiceProvider
{
    protected string $baseUrl;
    protected string $key;
    protected string $secret;
    protected string $account;

    public function __construct()
    {
        $this->baseUrl = config('services.fedex.base_url');
        $this->key     = config('services.fedex.api_key');
        $this->secret  = config('services.fedex.secret');
        $this->account = config('services.fedex.account_number');
    }

    public function getToken(): ?string
    {
        $response = Http::asForm()->post("{$this->baseUrl}/oauth/token", [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->key,
            'client_secret' => $this->secret,
        ]);

        return $response->ok() ? $response->json()['access_token'] : null;
    }

    public function getRates(array $from, array $to, float $weightKg): array
    {
        $token = $this->getToken();
        if (!$token) return [];

        $response = Http::withToken($token)->post("{$this->baseUrl}/rate/v1/rates/quotes", [
            "accountNumber" => ["value" => $this->account],
            "requestedShipment" => [
                "shipper"   => ["address" => $from],
                "recipient" => ["address" => $to],
                "pickupType" => "DROPOFF_AT_FEDEX_LOCATION",
                "rateRequestType" => ["ACCOUNT"],
                "requestedPackageLineItems" => [[
                    "weight" => ["units" => "KG", "value" => $weightKg]
                ]]
            ]
        ]);



        return $response->ok()
            ? $response->json()['output']['rateReplyDetails'] ?? []
            : [];
    }

    // app/Providers/FedexServiceProvider.php

    // app/Providers/FedexServiceProvider.php

    // app/Providers/FedexServiceProvider.php

    public function createShipment(array $shipmentData, string $transactionId): ?string
    {
        \Log::debug('FedEx createShipment called', [
            'transactionId' => $transactionId,
            'config' => [
                'baseUrl' => $this->baseUrl,
                'key' => substr($this->key, 0, 10) . '...',
                'secret' => substr($this->secret, 0, 10) . '...',
                'account' => $this->account
            ]
        ]);

        $token = $this->getToken();
        if (! $token) {
            \Log::error('FedEx createShipment: no token');
            return null;
        }

        \Log::debug('FedEx token obtained successfully');

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type'              => 'application/json',
                'x-customer-transaction-id' => $transactionId,
                'x-locale'                  => 'en_US',
            ])
            ->post("{$this->baseUrl}/ship/v1/shipments", $shipmentData);

        $body = $response->json();

        \Log::debug('FedEx createShipment response', [
            'status' => $response->status(),
            'body' => $body
        ]);

        if (! $response->ok()) {
            \Log::error('FedEx createShipment failed', [
                'status' => $response->status(),
                'body' => $body
            ]);
            return null;
        }

        // 1) Intentamos obtener el link de output.transactionShipments.0.labels.0.link
        $link = data_get($body, 'output.transactionShipments.0.labels.0.link');

        // 2) Si no existe, buscamos en pieceResponses…packageDocuments…url
        if (! $link) {
            $link = data_get($body,
                'output.transactionShipments.0.pieceResponses.0.packageDocuments.0.url'
            );
        }

        if (! $link) {
            \Log::error('FedEx createShipment: label link not found in response', [
                'full_response' => $body,
                'searched_paths' => [
                    'output.transactionShipments.0.labels.0.link',
                    'output.transactionShipments.0.pieceResponses.0.packageDocuments.0.url'
                ]
            ]);
            return null;
        }

        \Log::info('FedEx createShipment successful', ['labelUrl' => $link]);
        return $link;
    }






}
