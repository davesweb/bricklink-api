<?php

namespace Davesweb\BrinklinkApi\Exceptions;

use InvalidArgumentException;

class InvalidDirectionException extends InvalidArgumentException
{
    public static function forDirection(string $direction): static
    {
        return new self(sprintf('%s is not a valid direction.', $direction));
    }
}
