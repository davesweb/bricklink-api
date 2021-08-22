<?php

namespace Davesweb\BrinklinkApi\Enums;

use Davesweb\BrinklinkApi\Exceptions\InvalidDirectionException;

final class Direction
{
    public const IN  = 'in';
    public const OUT = 'out';

    private string $direction;

    public function __construct(string $direction)
    {
        if ($direction !== static::IN && $direction !== static::OUT) {
            throw InvalidDirectionException::forDirection($direction);
        }

        $this->direction = $direction;
    }

    public function __toString(): string
    {
        return $this->direction;
    }

    public function in(): static
    {
        $this->direction = static::IN;

        return $this;
    }

    public function out(): static
    {
        $this->direction = static::OUT;

        return $this;
    }

    public static function default(): static
    {
        return new static(static::IN);
    }

    public static function make(?string $direction = null): static
    {
        return $direction ? new static($direction) : static::default();
    }
}
