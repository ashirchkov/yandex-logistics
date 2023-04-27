<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay;

use AlexeyShirchkov\Yandex\Logistics\Client;

class BaseRequest
{

    protected Client $client;
    protected array $headers;

    public function __construct(Client $client) {

        $this->client = $client;

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->client->getApiKey(),
        ];

    }

}