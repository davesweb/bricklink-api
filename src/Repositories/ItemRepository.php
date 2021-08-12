<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\ValueObjects\PriceGuide;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\ItemTransformer;
use Davesweb\BrinklinkApi\Transformers\SubsetTransformer;
use Davesweb\BrinklinkApi\Transformers\SupersetTransformer;
use Davesweb\BrinklinkApi\Transformers\KnownColorTransformer;
use Davesweb\BrinklinkApi\Transformers\PriceGuideTransformer;

class ItemRepository extends BaseRepository
{
    protected SupersetTransformer $supersetTransformer;

    protected SubsetTransformer $subsetTransformer;

    protected PriceGuideTransformer $priceGuideTransformer;

    protected KnownColorTransformer $knownColorTransformer;

    public function __construct(
        BricklinkGateway $gateway,
        ItemTransformer $transformer,
        SupersetTransformer $supersetTransformer,
        SubsetTransformer $subsetTransformer,
        PriceGuideTransformer $priceGuideTransformer,
        KnownColorTransformer $knownColorTransformer,
    ) {
        parent::__construct($gateway, $transformer);

        $this->supersetTransformer   = $supersetTransformer;
        $this->subsetTransformer     = $subsetTransformer;
        $this->priceGuideTransformer = $priceGuideTransformer;
        $this->knownColorTransformer = $knownColorTransformer;
    }

    public function find(string $number, string $type = 'part'): ?Item
    {
        $uri = uri('/items/{type}/{number}', [
            'type'   => $type,
            'number' => $number,
        ]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Item $item */
        $item = $this->transformer->toObject($response->getData());

        return $item;
    }

    public function findItemImage(Item $item, int $colorId = 1): ?Item
    {
        $uri = uri('/items/{type}/{number}/images/{color_id}', [
            'type'     => $item->type,
            'number'   => $item->number,
            'color_id' => $colorId,
        ]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Item $item */
        $item = $this->transformer->toObject($response->getData());

        return $item;
    }

    public function supersets(string $number, string $type = 'part', ?int $colorId = null): iterable
    {
        $uri = uri('/items/{type}/{number}/supersets', [
            'type'     => $type,
            'number'   => $number,
            'color_id' => $colorId,
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->supersetTransformer->toObject($data);
        }

        return $values;
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
        $uri = uri('/items/{type}/{number}/subsets', [
            'type'   => $type,
            'number' => $number,
        ], [
            'color_id'       => $colorId,
            'box'            => $box ? 'true' : 'false',
            'instruction'    => $instruction ? 'true' : 'false',
            'break_minifigs' => $breakMinifigs ? 'true' : 'false',
            'break_subsets'  => $breakSubsets ? 'true' : 'false',
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->subsetTransformer->toObject($data);
        }

        return $values;
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
    ): ?PriceGuide {
        $uri = uri('/items/{type}/{number}/price', [
            'type'   => $type,
            'number' => $number,
        ], [
            'color_id'      => $colorId,
            'guide_type'    => $guideType,
            'new_or_used'   => $newOrUsed,
            'country_code'  => $countryCode,
            'region'        => $region,
            'currency_code' => $currencyCode,
            'vat'           => $vat,
        ]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var PriceGuide $priceGuide */
        $priceGuide = $this->priceGuideTransformer->toObject($response->getData());

        return $priceGuide;
    }

    public function knownColors(string $number, string $type = 'part'): iterable
    {
        $uri = uri('/items/{type}/{number}/colors', [
            'type'   => $type,
            'number' => $number,
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->knownColorTransformer->toObject($data);
        }

        return $values;
    }
}
