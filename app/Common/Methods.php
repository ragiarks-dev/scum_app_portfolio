<?php

namespace App\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class Methods
{
    private Client $guzzle;
    private array $response;

    public function __construct()
    {
        $this->guzzle = new Client();
        $this->response = [
            'status' => 200,
            'result' => [],
            'message' => [],
        ];
    }

    public function get(string $uri, array $params): array
    {
        try {
            $response = $this->guzzle->get(
                $uri,
                ['query' => $params]
            );

            $this->response['status'] = $response->getStatusCode();
            $this->response['result'] = $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error($e);
        }
        return $this->response;
    }

    public function post(string $uri, array $data): array
    {
        try {
            $response = $this->guzzle->post(
                $uri,
                [
                    'json' => $data
                ]
            );
            $this->response['status'] = $response->getStatusCode();
            $this->response['result'] = $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error($e);
        }
        return $this->response;
    }

}
