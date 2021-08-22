<?php

namespace Davesweb\BrinklinkApi\Enums;

use Davesweb\BrinklinkApi\Exceptions\InvalidGuideTypeException;

final class GuideType
{
    public const SOLD  = 'sold';
    public const STOCK = 'stock';

    private string $type;

    public function __construct(string $type)
    {
        if ($type !== static::SOLD && $type !== static::STOCK) {
            throw InvalidGuideTypeException::forType($type);
        }

        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function sold(): static
    {
        $this->type = static::SOLD;

        return $this;
    }

    public function stock(): static
    {
        $this->type = static::STOCK;

        return $this;
    }

    public static function default(): static
    {
        return new static(static::STOCK);
    }

    public static function make(?string $type = null): static
    {
        return $type ? new static($type) : static::default();
    }
}
