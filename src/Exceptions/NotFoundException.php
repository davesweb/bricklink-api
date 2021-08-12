<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public static function forId(mixed $id): static
    {
        return new static('Could not find a result for ID ' . $id);
    }
}
