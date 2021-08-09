<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use Davesweb\BrinklinkApi\BricklinkResponse;
use PHPUnit\Framework\Exception;

class ResourceException extends Exception
{
    public static function fromResponse(BricklinkResponse $response): static
    {
        return new static($response->getMeta()['description'], $response->getStatusCode());
    }
}