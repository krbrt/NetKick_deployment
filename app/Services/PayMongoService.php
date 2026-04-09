<?php

namespace App\Services;

use GuzzleHttp\Client;

class PayMongoService
{
    protected $client;
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
        if (!$this->secretKey) {
            \Log::warning('PayMongoService: PAYMONGO_SECRET_KEY missing in .env. GCash disabled. Get from dashboard.paymongo.com');
            $this->client = null;
            return;
        }
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->secretKey . ':'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createGcashSource($amount, $description = 'Netkicks Order')
    {
        if (!$this->client) {
            throw new \Exception('GCash payment not configured. Add PAYMONGO_SECRET_KEY to .env');
        }
        $billing = [
            'email' => request()->email ?? 'customer@example.com',
            'name' => request()->first_name . ' ' . request()->last_name,
            'phone' => request()->phone,
        ];

        // Create source
        $response = $this->client->post('v1/sources', [
            'json' => [
                'data' => [
                    'attributes' => [
                        'type' => 'gcash',
                        'amount' => $amount * 100, // cents
                        'description' => $description,
                        'billing' => $billing,
                        'show_photos' => true,
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody(), true)['data']['attributes'];
    }

    public function getPaymentStatus($sourceId)
    {
        if (!$this->client) {
            throw new \Exception('GCash payment not configured. Add PAYMONGO_SECRET_KEY to .env');
        }
        $response = $this->client->get("v1/sources/{$sourceId}");
        return json_decode($response->getBody(), true)['data']['attributes'];
    }
}

