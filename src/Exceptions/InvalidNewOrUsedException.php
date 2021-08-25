<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use InvalidArgumentException;

class InvalidNewOrUsedException extends InvalidArgumentException
{
    public static function forType(string $type): static
    {
        return new self(sprintf('%s is not a valid type.', $type));
    }
}
