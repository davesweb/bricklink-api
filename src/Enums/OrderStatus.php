<?php

namespace Davesweb\BrinklinkApi\Enums;

final class OrderStatus
{
    /**
     * @see https://help.bricklink.com/hc/en-us/articles/360038487353-Order-Status
     *
     * @var array|string[]
     */
    private array $validStatuses = [
        'Pending',
        'Updated',
        'Processing',
        'Ready',
        'Paid',
        'Packed',
        'Shipped',
        'Received',
        'Completed',
        'OCR',
        'NPB',
        'NPX',
        'NRS',
        'NSS',
        'Cancelled',
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

    public function pending(): static
    {
        $this->statuses[] = 'Pending';

        return $this;
    }

    public function withoutPending(): static
    {
        $this->statuses[] = '-Pending';

        return $this;
    }

    public function updated(): static
    {
        $this->statuses[] = 'Updated';

        return $this;
    }

    public function withoutUpdated(): static
    {
        $this->statuses[] = '-Updated';

        return $this;
    }

    public function processing(): static
    {
        $this->statuses[] = 'Processing';

        return $this;
    }

    public function withoutProcessing(): static
    {
        $this->statuses[] = '-Processing';

        return $this;
    }

    public function ready(): static
    {
        $this->statuses[] = 'Ready';

        return $this;
    }

    public function withoutReady(): static
    {
        $this->statuses[] = '-Ready';

        return $this;
    }

    public function paid(): static
    {
        $this->statuses[] = 'Paid';

        return $this;
    }

    public function withoutPaid(): static
    {
        $this->statuses[] = '-Paid';

        return $this;
    }

    public function packed(): static
    {
        $this->statuses[] = 'Packed';

        return $this;
    }

    public function withoutPacked(): static
    {
        $this->statuses[] = '-Packed';

        return $this;
    }

    public function shipped(): static
    {
        $this->statuses[] = 'Shipped';

        return $this;
    }

    public function withoutShipped(): static
    {
        $this->statuses[] = '-Shipped';

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

    public function ocr(): static
    {
        $this->statuses[] = 'OCR';

        return $this;
    }

    public function withoutOcr(): static
    {
        $this->statuses[] = '-OCR';

        return $this;
    }

    public function npb(): static
    {
        $this->statuses[] = 'NPB';

        return $this;
    }

    public function withoutNpb(): static
    {
        $this->statuses[] = '-NPB';

        return $this;
    }

    public function npx(): static
    {
        $this->statuses[] = 'NPX';

        return $this;
    }

    public function withoutNpx(): static
    {
        $this->statuses[] = '-NPX';

        return $this;
    }

    public function nrs(): static
    {
        $this->statuses[] = 'NRS';

        return $this;
    }

    public function withoutNrs(): static
    {
        $this->statuses[] = '-NRS';

        return $this;
    }

    public function nss(): static
    {
        $this->statuses[] = 'NSS';

        return $this;
    }

    public function withoutNss(): static
    {
        $this->statuses[] = '-NSS';

        return $this;
    }

    public function cancelled(): static
    {
        $this->statuses[] = 'Cancelled';

        return $this;
    }

    public function withoutCancelled(): static
    {
        $this->statuses[] = '-Cancelled';

        return $this;
    }
}
