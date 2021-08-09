<?php

namespace Davesweb\BrinklinkApi;

use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;

class TestBricklinkGateway implements BricklinkGateway
{
    private ?BricklinkResponse $response;

    public function __construct(?BricklinkResponse $response)
    {
        $this->response = $response;
    }

    public function request(string $method, string $uri, array $options = []): BricklinkResponse
    {
        return $this->response;
    }

    public function get(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('GET', $uri, $options);
    }

    public function post(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('POST', $uri, $options);
    }

    public function put(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('PUT', $uri, $options);
    }

    public function delete(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('DELETE', $uri, $options);
    }
}
