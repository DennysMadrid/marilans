<?php

namespace App\Services;

use GuzzleHttp\Client;

class AmazonService
{
    protected $client;
    protected $accessKeyId;
    protected $secretAccessKey;
    protected $region;

    public function __construct()
    {
        $this->client = new Client();
        $this->accessKeyId = config('amazon.client_id');
        $this->secretAccessKey = config('amazon.secret_key');
        $this->region = config('amazon.region');
    }

    public function getProductDetails($asin)
    {
        $url = "https://sellingpartnerapi-na.amazon.com/listings/2021-08-01/items/{$asin}";
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'x-api-key' => $this->accessKeyId,
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    private function getAccessToken()
    {
        // Implement OAuth token retrieval here
        // This is a placeholder


        $client = new Client();
        $response = $client->post('https://api.amazon.com/auth/o2/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => config('amazon.refresh_token'),
                'client_id' => config('amazon.client_id'),
                'client_secret' => config('amazon.client_secret'),
            ],
        ]);
        $data = json_decode($response->getBody(), true);

        return $data['access_token'];
    }
}
