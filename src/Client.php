<?php

namespace AlexeyShirchkov\Yandex\Logistics;

use Psr\Http\Client\ClientInterface;
use AlexeyShirchkov\Yandex\Logistics\Api\AnotherDay;
use AlexeyShirchkov\Yandex\Logistics\Exception\NotImplementedException;

class Client
{

    private string $host = 'https://b2b-authproxy.taxi.yandex.net';
    private string $testHost = 'https://b2b.taxi.tst.yandex.net';

    private ClientInterface $client;
    private string $apiKey;
    private bool $testMode;

    public function __construct(ClientInterface $client, string $apiKey, $test = false) {

        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->testMode = $test;

    }

    public function getApiKey(): string {
        return $this->apiKey;
    }

    public function isTestMode(): bool {
        return $this->testMode;
    }

    public function getHost(): string {
        return $this->isTestMode() ? $this->testHost : $this->host;
    }

    public function getHttpClient(): ClientInterface {
        return $this->client;
    }

    public function sameDay() {
        throw new NotImplementedException(get_class($this), __METHOD__);
    }

    public function anotherDay(): AnotherDay {
        return new AnotherDay($this);
    }

}