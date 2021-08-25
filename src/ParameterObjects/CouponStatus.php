<?php

namespace Davesweb\BrinklinkApi\ParameterObjects;

final class CouponStatus
{
    private array $validStatuses = [
        'O' => 'Open',
        'S' => 'Redeemed',
        'D' => 'Denied',
        'E' => 'Expired',
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

    public function open(): static
    {
        $this->statuses[] = 'O';

        return $this;
    }

    public function withoutOpen(): static
    {
        $this->statuses[] = '-O';

        return $this;
    }

    public function redeemed(): static
    {
        $this->statuses[] = 'S';

        return $this;
    }

    public function withoutRedeemed(): static
    {
        $this->statuses[] = '-S';

        return $this;
    }

    public function denied(): static
    {
        $this->statuses[] = 'D';

        return $this;
    }

    public function withoutDenied(): static
    {
        $this->statuses[] = '-D';

        return $this;
    }

    public function expired(): static
    {
        $this->statuses[] = 'E';

        return $this;
    }

    public function withoutExpired(): static
    {
        $this->statuses[] = '-E';

        return $this;
    }
}
