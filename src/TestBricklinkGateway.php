<?php

namespace Davesweb\BrinklinkApi;

use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;

class TestBricklinkGateway implements BricklinkGateway
{
    private array|BricklinkResponse|null $response;

//    public function __construct(?BricklinkResponse $response)
//    {
//        $this->response = $response;
//    }

    public function __construct(array|BricklinkResponse|null $response)
    {
        $this->response = $response;
    }

    public function request(string $method, string $uri, array $options = []): BricklinkResponse
    {
        if (!is_array($this->response)) {
            return $this->response;
        }

        return $this->response[$uri] ?? BricklinkResponse::test(404, []);
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
