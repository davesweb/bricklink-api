<?php

namespace Davesweb\BrinklinkApi\Contracts;

use Davesweb\BrinklinkApi\BricklinkResponse;

interface BricklinkGateway
{
    public function request(string $method, string $uri, array $options = []): BricklinkResponse;

    public function get(string $uri, array $options = []): BricklinkResponse;

    public function post(string $uri, array $options = []): BricklinkResponse;

    public function put(string $uri, array $options = []): BricklinkResponse;

    public function delete(string $uri, array $options = []): BricklinkResponse;
}
