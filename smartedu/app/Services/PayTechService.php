<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayTechService
{
    private string $apiKey;
    private string $apiSecret;
    private string $env;
    private string $apiBase;
    private string $currency;

    public function __construct()
    {
        $this->apiKey    = config('paytech.api_key');
        $this->apiSecret = config('paytech.api_secret');
        $this->env       = config('paytech.env', 'test');
        $this->apiBase   = config('paytech.api_base');
        $this->currency  = config('paytech.currency', 'XOF');
    }

    /**
     * Initie un paiement PayTech et retourne le redirectUrl.
     *
     * @param  array{
     *   item_name: string,
     *   item_price: int,
     *   ref_command: string,
     *   command_name: string,
     *   ipn_url: string,
     *   success_url: string,
     *   cancel_url: string,
     *   custom_field?: array
     * } $params
     * @return array{success: bool, redirect_url?: string, token?: string, error?: string}
     */
    public function initiatePayment(array $params): array
    {
        $payload = [
            'item_name'    => $params['item_name'],
            'item_price'   => (int) $params['item_price'],
            'currency'     => $this->currency,
            'ref_command'  => $params['ref_command'],
            'command_name' => $params['command_name'],
            'env'          => $this->env,
            'ipn_url'      => $params['ipn_url'],
            'success_url'  => $params['success_url'],
            'cancel_url'   => $params['cancel_url'],
        ];

        if (!empty($params['custom_field'])) {
            $payload['custom_field'] = json_encode($params['custom_field']);
        }

        $response = Http::withHeaders([
            'API_KEY'    => $this->apiKey,
            'API_SECRET' => $this->apiSecret,
            'Accept'     => 'application/json',
        ])->post($this->apiBase . config('paytech.endpoint'), $payload);

        if ($response->failed()) {
            return [
                'success' => false,
                'error'   => 'Erreur de connexion PayTech : ' . $response->status(),
            ];
        }

        $data = $response->json();

        if (isset($data['success']) && $data['success'] == 1 && isset($data['redirect_url'])) {
            return [
                'success'      => true,
                'redirect_url' => $data['redirect_url'],
                'token'        => $data['token'] ?? null,
            ];
        }

        return [
            'success' => false,
            'error'   => $data['errors'][0] ?? 'Erreur inconnue PayTech.',
        ];
    }
}
