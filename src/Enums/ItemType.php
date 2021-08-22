<?php

namespace Davesweb\BrinklinkApi\Enums;

final class ItemType
{
    private array $validTypes = [
        'MINIFIG',
        'PART',
        'SET',
        'BOOK',
        'GEAR',
        'CATALOG',
        'INSTRUCTION',
        'UNSORTED_LOT',
        'ORIGINAL_BOX',
    ];

    private array $types = [];

    public function __toString(): string
    {
        return implode(',', $this->types);
    }

    public static function default(): static
    {
        return new static();
    }

    public static function make(): static
    {
        return new static();
    }

    public function minifig(): static
    {
        $this->types[] = 'MINIFIG';

        return $this;
    }

    public function withoutMinifig(): static
    {
        $this->types[] = '-MINIFIG';

        return $this;
    }

    public function part(): static
    {
        $this->types[] = 'PART';

        return $this;
    }

    public function withoutPart(): static
    {
        $this->types[] = '-PART';

        return $this;
    }

    public function set(): static
    {
        $this->types[] = 'SET';

        return $this;
    }

    public function withoutSet(): static
    {
        $this->types[] = '-SET';

        return $this;
    }

    public function book(): static
    {
        $this->types[] = 'BOOK';

        return $this;
    }

    public function withoutBook(): static
    {
        $this->types[] = '-BOOK';

        return $this;
    }

    public function gear(): static
    {
        $this->types[] = 'GEAR';

        return $this;
    }

    public function withoutGear(): static
    {
        $this->types[] = '-GEAR';

        return $this;
    }

    public function catelog(): static
    {
        $this->types[] = 'CATALOG';

        return $this;
    }

    public function withoutCatelog(): static
    {
        $this->types[] = '-CATALOG';

        return $this;
    }

    public function instructions(): static
    {
        $this->types[] = 'INSTRUCTION';

        return $this;
    }

    public function withoutInstructions(): static
    {
        $this->types[] = '-INSTRUCTION';

        return $this;
    }

    public function unsortedLot(): static
    {
        $this->types[] = 'UNSORTED_LOT';

        return $this;
    }

    public function withoutUnsortedLot(): static
    {
        $this->types[] = '-UNSORTED_LOT';

        return $this;
    }

    public function originalBox(): static
    {
        $this->types[] = 'ORIGINAL_BOX';

        return $this;
    }

    public function withoutOriginalBox(): static
    {
        $this->types[] = '-ORIGINAL_BOX';

        return $this;
    }
}
