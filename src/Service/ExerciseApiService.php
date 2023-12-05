<?php



namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExerciseApiService
{/*
    private $httpClient;
    private $apiEndpoint;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiEndpoint, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiEndpoint = $apiEndpoint;
        $this->apiKey = $apiKey;
    }

    public function getExercises(): array
    {
        $response = $this->httpClient->request('GET', "{$this->apiEndpoint}/exercise/", [
            'headers' => [
                'Authorization' => "Token {$this->apiKey}",
            ],
        ]);

        return $response->toArray();
    }*/
}
