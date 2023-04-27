<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay;

use Psr\Http\Client\ClientExceptionInterface;
use AlexeyShirchkov\Yandex\Logistics\Http\Request;
use AlexeyShirchkov\Yandex\Logistics\Http\Response;

class OrderRequest extends BaseRequest
{

    /**
     * @throws ClientExceptionInterface
     */
    public function createOrder(array $params, $unix = true): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/offers/create')
                ->setQuery(['send_unix' => json_encode($unix)])
                ->setHeaders($this->headers)
                ->setParams($params)
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function editOrder(string $requestId, array $params = []): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/request/edit')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_id' => $requestId,
                    ...$params,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function cancelOrder(string $requestId): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/request/cancel')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_id' => $requestId,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function confirmOrder(string $offerId): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/offers/confirm')
                ->setHeaders($this->headers)
                ->setParams(['offer_id' => $offerId])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getOrder(string $requestId, bool $slim = false): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'GET'))
                ->setPath('/api/b2b/platform/request/info')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_id' => $requestId,
                    'slim' => json_encode($slim),
                ])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getOrders(array $params): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/requests/info')
                ->setHeaders($this->headers)
                ->setParams($params)
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function redeliveryOrder(string $requestId, array $params = []): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/request/redelivery_options')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_id' => $requestId,
                    ...$params,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function orderStatusHistory(string $requestId): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'GET'))
                ->setPath('/api/b2b/platform/request/history')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_id' => $requestId,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

}