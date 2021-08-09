<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

class ConnectionException extends Exception
{
    public static function guzzleError(GuzzleException $guzzleException): static
    {
        return new static(
            $guzzleException->getMessage(),
            $guzzleException->getCode(),
            $guzzleException
        );
    }
}
