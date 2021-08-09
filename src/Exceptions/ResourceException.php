<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use PHPUnit\Framework\Exception;
use Davesweb\BrinklinkApi\BricklinkResponse;

class ResourceException extends Exception
{
    public static function fromResponse(BricklinkResponse $response): static
    {
        return new static($response->getMeta()['description'], $response->getStatusCode());
    }
}
