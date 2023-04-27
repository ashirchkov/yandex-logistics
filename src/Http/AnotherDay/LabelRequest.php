<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http\AnotherDay;

use Psr\Http\Client\ClientExceptionInterface;
use AlexeyShirchkov\Yandex\Logistics\Http\Request;
use AlexeyShirchkov\Yandex\Logistics\Http\Response;

class LabelRequest extends BaseRequest
{

    /**
     * @throws ClientExceptionInterface
     */
    public function generateLabels(array $requestIds, array $params = []): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'POST'))
                ->setPath('/api/b2b/platform/request/generate-labels')
                ->setHeaders($this->headers)
                ->setParams([
                    'request_ids' => $requestIds,
                    ...$params,
                ])
                ->getRequest()
        );

        return new Response($response);

    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getHandoverAct(array $params): Response {

        $response = $this->client->getHttpClient()->sendRequest(
            (new Request($this->client->getHost(), 'GET'))
                ->setPath('/api/b2b/platform/request/get-handover-act')
                ->setHeaders($this->headers)
                ->setParams($params)
                ->getRequest()
        );

        return new Response($response);

    }

}