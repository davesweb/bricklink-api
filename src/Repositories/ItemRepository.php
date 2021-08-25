<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\Enums\ItemType;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\ItemTransformer;
use Davesweb\BrinklinkApi\Transformers\KnownColorTransformer;

class ItemRepository extends BaseRepository
{
    protected KnownColorTransformer $knownColorTransformer;

    public function __construct(
        BricklinkGateway $gateway,
        ItemTransformer $transformer,
        KnownColorTransformer $knownColorTransformer,
    ) {
        parent::__construct($gateway, $transformer);

        $this->knownColorTransformer = $knownColorTransformer;
    }

    public function find(string $number, ?ItemType $type = null): ?Item
    {
        $uri = uri('/items/{type}/{number}', [
            'type'   => toString($type, ItemType::default()),
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

    public function findOrFail(string $number, ?ItemType $type = null): Item
    {
        return $this->find($number, $type) ?? throw NotFoundException::forId($number);
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

    public function findOrFailItemImage(Item $item, int $colorId = 1): Item
    {
        return $this->findItemImage($item, $colorId) ?? throw NotFoundException::forId($item->number);
    }

    public function knownColors(string $number, ?ItemType $type = null): iterable
    {
        $uri = uri('/items/{type}/{number}/colors', [
            'type'   => $type ? (string) $type : ItemType::default(),
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
