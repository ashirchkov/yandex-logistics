<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface;

class Response
{

    protected string $body;

    protected int $status;

    protected array $headers;

    protected array $errors = [];

    protected mixed $result;

    protected Serializer $serializer;

    public function __construct(ResponseInterface $response) {

        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new IdenticalPropertyNamingStrategy()
            )
            ->build();

        $this->status = $response->getStatusCode();
        $this->headers = $response->getHeaders();
        $this->body = $result = (string)$response->getBody();

        if (
            !\in_array($result, ['', 'null', 'true', 'false'], true) &&
            str_starts_with($response->getHeaderLine('Content-type'), 'application/json')
        ) {
            $result = $this->serializer->deserialize($result, 'array', 'json');
        }

        $this->result = $result;

        if (!$this->isSuccess()) {
            // Oh this Yandex....
            if (!empty($result['error_details'])) {
                $this->errors = $result['error_details'];
            } else if (!empty($result['message'])) {
                $this->errors[] = $result['message'];
            } else if (!empty($result['description'])) {
                $this->errors[] = $result['description'];
            } else if (!empty($result['details']['debug_message'])) {
                $this->errors[] = $result['details']['debug_message'];
            } else {
                $this->errors[] = $response->getReasonPhrase();
            }
        }

    }

    public function isSuccess(): bool {
        return $this->getStatus() >= 200 && $this->getStatus() <= 299 && empty($this->getErrors());
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function getResult(string $format = '') {
        return empty($format) ? $this->result : $this->serializer->deserialize($this->body, $format, 'json');
    }

}

