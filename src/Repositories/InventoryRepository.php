<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Inventory;
use Davesweb\BrinklinkApi\Transformers\InventoryTransformer;

class InventoryRepository extends BaseRepository
{
    public function index(
        string|array|null $itemTypes = null,
        string|array|null $statuses = null,
        int|array|null $categoryIds = null,
        int|array|null $colorIds = null
    ): iterable {
        $uri = $this->uri('inventories', [], [
            'item_types'  => $this->toParam($itemTypes),
            'status'      => $this->toParam($statuses),
            'category_id' => $this->toParam($categoryIds),
            'color_id'    => $this->toParam($colorIds),
        ]);

        $response    = $this->gateway->get($uri);
        $values      = [];

        foreach ($response->getData() as $data) {
            $values[] = InventoryTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Inventory
    {
        $response = $this->gateway->get($this->uri('inventories/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Inventory $inventory */
        $inventory = InventoryTransformer::toObject($response->getData());

        return $inventory;
    }

    public function store(Inventory $inventory): Inventory
    {
        $response = $this->gateway->post('inventories', InventoryTransformer::toArray($inventory));

        /** @var Inventory $newInventory */
        $newInventory = InventoryTransformer::toObject($response->getData());

        return $newInventory;
    }

    public function update(Inventory $inventory): Inventory
    {
        $response = $this->gateway->put($this->uri('inventories/{id}', ['id' => $inventory->inventoryId]), InventoryTransformer::toArray($inventory));

        /** @var Inventory $newInventory */
        $newInventory = InventoryTransformer::toObject($response->getData());

        return $newInventory;
    }

    public function delete(Inventory $inventory): bool
    {
        $response = $this->gateway->delete($this->uri('inventories/{id}', ['id' => $inventory->inventoryId]));

        return $response->isSuccessful();
    }
}
