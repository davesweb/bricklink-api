<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;

class ItemRepository extends BaseRepository
{
    public function find(string $number, string $type = 'part'): Item
    {
    }

    public function supersets(string $number, string $type = 'part', ?int $colorId = null): iterable
    {
    }

    public function subsets(
        string $number,
        string $type = 'part',
        ?int $colorId = null,
        ?bool $box = null,
        ?bool $instruction = null,
        ?bool $breakMinifigs = null,
        ?bool $breakSubsets = null,
    ): iterable {
    }

    public function priceGuide(
        string $number,
        string $type = 'part',
        ?int $colorId = null,
        string $guideType = 'stock',
        string $newOrUsed = 'N',
        ?string $countryCode = null,
        ?string $region = null,
        ?string $currencyCode = null,
        string $vat = 'N',
    ): PriceGuide {
    }

    public function knownColors(): iterable
    {
    }
}
