<?php

namespace Davesweb\BrinklinkApi\Enums;

final class InventoryStatus
{
    private array $validStatuses = [
        'Y' => 'Available',
        'S' => 'In stockroom A',
        'B' => 'In stockroom B',
        'C' => 'In stockroom C',
        'N' => 'Unavailable',
        'R' => 'Reserved',
    ];

    private array $statuses = [];

    public function __toString(): string
    {
        return implode(',', $this->statuses);
    }

    public static function default(): static
    {
        return new static();
    }

    public static function make(): static
    {
        return new static();
    }

    public function available(): static
    {
        $this->statuses[] = 'Y';

        return $this;
    }

    public function withoutAvailable(): static
    {
        $this->statuses[] = '-Y';

        return $this;
    }

    public function inStockroomA(): static
    {
        $this->statuses[] = 'S';

        return $this;
    }

    public function withoutStockroomA(): static
    {
        $this->statuses[] = '-S';

        return $this;
    }

    public function inStockroomB(): static
    {
        $this->statuses[] = 'B';

        return $this;
    }

    public function withoutStockroomB(): static
    {
        $this->statuses[] = '-B';

        return $this;
    }

    public function inStockroomC(): static
    {
        $this->statuses[] = 'C';

        return $this;
    }

    public function withoutStockroomC(): static
    {
        $this->statuses[] = '-C';

        return $this;
    }

    public function unavailable(): static
    {
        $this->statuses[] = 'N';

        return $this;
    }

    public function withoutUnavailable(): static
    {
        $this->statuses[] = '-N';

        return $this;
    }

    public function reserved(): static
    {
        $this->statuses[] = 'R';

        return $this;
    }

    public function withoutReserved(): static
    {
        $this->statuses[] = '-R';

        return $this;
    }
}
