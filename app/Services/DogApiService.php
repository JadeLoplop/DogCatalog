<?php

namespace App\Services;
use GuzzleHttp\Client;

class DogApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://dog.ceo/api/'
        ]);
    }

    public function getListBreeds()
    {
        $response = $this->client->request('GET', 'breeds/list/all');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getRandomDog($count)
    {
        $endpoint = "breeds/image/random/{$count}";
        $response = $this->client->request('GET', $endpoint);
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['message'])) {
            return $data['message'];
        } else {
            return [];
        }
    }
}
