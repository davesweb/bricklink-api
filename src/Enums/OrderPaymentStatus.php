<?php

namespace Davesweb\BrinklinkApi\Enums;

class OrderPaymentStatus
{
    /**
     * @see https://www.bricklink.com/help.asp?helpID=121
     *
     * @var array|string[]
     */
    private array $validStatuses = [
        'None',
        'Sent',
        'Received',
        'Clearing',
        'Returned',
        'Bounced',
        'Completed',
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

    public function none(): static
    {
        $this->statuses[] = 'None';

        return $this;
    }

    public function withoutNone(): static
    {
        $this->statuses[] = '-None';

        return $this;
    }

    public function sent(): static
    {
        $this->statuses[] = 'Sent';

        return $this;
    }

    public function withoutSent(): static
    {
        $this->statuses[] = '-Sent';

        return $this;
    }

    public function received(): static
    {
        $this->statuses[] = 'Received';

        return $this;
    }

    public function withoutReceived(): static
    {
        $this->statuses[] = '-Received';

        return $this;
    }

    public function clearing(): static
    {
        $this->statuses[] = 'Clearing';

        return $this;
    }

    public function withoutClearing(): static
    {
        $this->statuses[] = '-Clearing';

        return $this;
    }

    public function returned(): static
    {
        $this->statuses[] = 'Returned';

        return $this;
    }

    public function withoutReturned(): static
    {
        $this->statuses[] = '-Returned';

        return $this;
    }

    public function bounced(): static
    {
        $this->statuses[] = 'Bounced';

        return $this;
    }

    public function withoutBounced(): static
    {
        $this->statuses[] = '-Bounced';

        return $this;
    }

    public function completed(): static
    {
        $this->statuses[] = 'Completed';

        return $this;
    }

    public function withoutCompleted(): static
    {
        $this->statuses[] = '-Completed';

        return $this;
    }
}
