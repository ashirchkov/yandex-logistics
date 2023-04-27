<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay;

use Psr\Http\Client\ClientExceptionInterface;
use AlexeyShirchkov\Yandex\Logistics\Http\Request;
use AlexeyShirchkov\Yandex\Logistics\Http\Response;

class CalculateRequest extends BaseRequest
{

    /**
     * @throws ClientExceptionInterface
     */
    public function calculatePrice(array $params): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/pricing-calculator')
                ->setHeaders($this->headers)
                ->setParams($params)
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function calculateIntervals(string $stationId, array $params = []): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'GET'))
                ->setPath('/api/b2b/platform/offers/info')
                ->setHeaders($this->headers)
                ->setParams([
                    'station_id' => $stationId,
                    ...$params,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

}