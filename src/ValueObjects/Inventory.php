<?php

namespace Davesweb\BrinklinkApi\ValueObjects;

use DateTime;

class Inventory
{
    public function __construct(
        public ?int $inventoryId = null,
        public ?Item $item = null,
        public ?int $colorId = null,
        public ?string $colorName = null,
        public ?int $quantity = null,
        public ?string $newOrUsed = null,
        public ?string $completeness = null,
        public ?float $unitPrice = null,
        public ?int $bindId = null,
        public ?string $description = null,
        public ?string $remarks = null,
        public ?int $bulk = null,
        public ?bool $isRetain = null,
        public ?bool $isStockRoom = null,
        public ?string $stockRoomId = null,
        public ?DateTime $dateCreated = null,
        public ?float $myCost = null,
        public ?int $saleRate = null,
        public ?int $tierQuantity1 = null,
        public ?int $tierQuantity2 = null,
        public ?int $tierQuantity3 = null,
        public ?float $tierPrice1 = null,
        public ?float $tierPrice2 = null,
        public ?float $tierPrice3 = null,
        public ?float $myWeight = null,
    ) {
    }
}
