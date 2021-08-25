<?php

namespace Davesweb\BrinklinkApi\ParameterObjects;

use Davesweb\BrinklinkApi\Exceptions\InvalidNewOrUsedException;

final class NewOrUsed
{
    public const NEW  = 'N';
    public const USED = 'U';

    private string $type;

    public function __construct(string $type)
    {
        if ($type !== static::NEW && $type !== static::USED) {
            throw InvalidNewOrUsedException::forType($type);
        }

        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function new(): static
    {
        $this->type = static::NEW;

        return $this;
    }

    public function used(): static
    {
        $this->type = static::USED;

        return $this;
    }

    public static function default(): static
    {
        return new static(static::NEW);
    }

    public static function make(?string $type = null): static
    {
        return $type ? new static($type) : static::default();
    }
}
