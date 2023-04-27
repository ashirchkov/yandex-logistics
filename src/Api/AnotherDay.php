<?php

namespace AlexeyShirchkov\Yandex\Logistics\Api;

use AlexeyShirchkov\Yandex\Logistics\Client;
use AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay\OrderRequest;
use AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay\LabelRequest;
use AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay\LocationRequest;
use AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay\CalculateRequest;

class AnotherDay
{

    private Client $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function calculate(): CalculateRequest {
        return new CalculateRequest($this->client);
    }

    public function location(): LocationRequest {
        return new LocationRequest($this->client);
    }

    public function order(): OrderRequest {
        return new OrderRequest($this->client);
    }

    public function label(): LabelRequest {
        return new LabelRequest($this->client);
    }


}