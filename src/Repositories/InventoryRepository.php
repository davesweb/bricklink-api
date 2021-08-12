<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\param;
use Davesweb\BrinklinkApi\ValueObjects\Inventory;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\InventoryTransformer;

class InventoryRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, InventoryTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(
        string|array|null $itemTypes = null,
        string|array|null $statuses = null,
        int|array|null $categoryIds = null,
        int|array|null $colorIds = null
    ): iterable {
        $uri = uri('inventories', [], [
            'item_types'  => param($itemTypes),
            'status'      => param($statuses),
            'category_id' => param($categoryIds),
            'color_id'    => param($colorIds),
        ]);

        $response    = $this->gateway->get($uri);
        $values      = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Inventory
    {
        $response = $this->gateway->get(uri('inventories/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Inventory $inventory */
        $inventory = $this->transformer->toObject($response->getData());

        return $inventory;
    }

    public function findOrFail(int $id): Inventory
    {
        return $this->find($id) ?? throw NotFoundException::forId($id);
    }

    public function store(Inventory $inventory): Inventory
    {
        $response = $this->gateway->post('inventories', $this->transformer->toArray($inventory));

        /** @var Inventory $newInventory */
        $newInventory = $this->transformer->toObject($response->getData());

        return $newInventory;
    }

    public function update(Inventory $inventory): Inventory
    {
        $response = $this->gateway->put(uri('inventories/{id}', ['id' => $inventory->inventoryId]), $this->transformer->toArray($inventory));

        /** @var Inventory $newInventory */
        $newInventory = $this->transformer->toObject($response->getData());

        return $newInventory;
    }

    public function delete(Inventory $inventory): bool
    {
        $response = $this->gateway->delete(uri('inventories/{id}', ['id' => $inventory->inventoryId]));

        return $response->isSuccessful();
    }
}
