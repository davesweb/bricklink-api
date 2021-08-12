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

        return $uri . (false !== stripos($uri, '?') ? '&' : '?') . http_build_query($params);
    }
}
