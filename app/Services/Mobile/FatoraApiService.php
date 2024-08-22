<?php

namespace App\Services\Mobile;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class FatoraApiService.
 */
class FatoraApiService
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://egate-t.fatora.me',
            'auth' => ['nada', 'nada@123'],
        ]);
    }

    public function createPayment($data)
    {
        try {
            $data['terminalId'] = 14740090;
            $data['lang'] = 'ar';
            $data['callbackURL'] = route('fatora-payment-callback');
            //$data['triggerURL'] = route('fatora-payment-trigger');

            $response = $this->client->post('/api/create-payment', [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }
    }

    public function paymentStatus($id)
    {
        try {

            $response = $this->client->get('/api/get-payment-status/' . $id);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }
    }
}
