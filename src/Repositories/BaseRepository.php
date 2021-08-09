<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;

abstract class BaseRepository
{
    protected BricklinkGateway $gateway;

    public function __construct(BricklinkGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    protected function uri(string $uri, array $replace = [], array $params = []): string
    {
        $keys = array_map(fn (string $key) => '{'.$key.'}', array_keys($replace));

        $uri = str_replace($keys, array_values($replace), $uri);

        if (0 === count($params)) {
            return $uri;
        }

        return $uri.'?'.http_build_query($params);
    }

    protected function toParam(mixed $values, ?string $paramName = null): ?string
    {
        if (null === $values) {
            return null;
        }

        if (is_array($values)) {
            $value = implode(',', $values);
        } else {
            $value = $values;
        }

        return null !== $paramName ? $paramName.'='.$value : $value;
    }
}
