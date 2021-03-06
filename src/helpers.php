<?php

namespace Davesweb;

if (!function_exists('uri')) {
    function uri(string $uri, array $replace = [], array $params = []): string
    {
        $keys = array_map(fn (string $key) => '{' . $key . '}', array_keys($replace));

        $uri = str_replace($keys, array_values($replace), $uri);

        if (0 === count($params)) {
            return $uri;
        }

        return rtrim($uri, '/') . (false !== stripos($uri, '?') ? '&' : '?') . http_build_query($params);
    }
}

if (!function_exists('toString')) {
    function toString(mixed $stringable, mixed $default = null): ?string
    {
        return null !== $stringable ? (string) $stringable : (null !== $default ? (string) $default : null);
    }
}
