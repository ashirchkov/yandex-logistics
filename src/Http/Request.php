<?php

namespace AlexeyShirchkov\Yandex\Logistics\Http;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;

class Request
{

    private string $method;
    private array $headers;
    private string $host;
    private string $path;
    private array $query = [];
    private array $params = [];

    public function __construct(string $host, string $method = 'GET') {

        $this->host = $host;
        $this->method = $method;

    }

    public function setHeaders(array $headers): static {

        $this->headers = $headers;

        return $this;

    }

    public function setPath(string $path): static {

        $this->path = $path;

        return $this;

    }

    public function setQuery(array $queryParams): static {

        $this->query = $queryParams;

        return $this;

    }

    public function setParams(array $params): static {

        $this->params = $params;

        return $this;

    }

    public function getRequest(): RequestInterface {

        $uri = (new Psr17Factory())->createUri($this->host);
        if (!empty($this->path)) {
            $uri = $uri->withPath($this->path);
        }

        if (!empty($this->query)) {
            $uri = $uri->withQuery(http_build_query($this->query));
        }

        $request = (new Psr17Factory())->createRequest($this->method, $uri);

        if (!empty($this->headers)) {
            foreach ($this->headers as $key => $value) {
                $request = $request->withHeader($key, $value);
            }
        }

        if (!empty($this->params)) {

            switch ($this->method) {
                case 'GET':
                    $request = $request->withUri(
                        $uri->withQuery(
                            http_build_query(
                                array_merge($this->query, $this->params)
                            )
                        )
                    );
                    break;
                case 'POST':
                    $request = $request->withBody(
                        (new Psr17Factory())->createStream(
                            json_encode($this->params)
                        )
                    );
                    break;
                default:
                    break;
            }

        }

        return $request;

    }

}
