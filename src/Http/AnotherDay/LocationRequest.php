<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;
use AlexeyShirchkov\Yandex\Logistics\Http\Request;
use AlexeyShirchkov\Yandex\Logistics\Http\Response;

class LocationRequest extends BaseRequest
{

    /**
     * @throws GuzzleException
     * @throws ClientExceptionInterface
     */
    public function getGeoIdByAddress(string $address): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/location/detect')
                ->setHeaders($this->headers)
                ->setParams(['location' => $address])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getPointList(array $params = []): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/pickup-points/list')
                ->setHeaders($this->headers)
                ->setParams($params)
                ->getRequest()
        );

        return new Response($response);

    }

}