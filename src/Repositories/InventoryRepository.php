<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Inventory;

class InventoryRepository extends BaseRepository
{
    public function index(
        string|array|null $itemTypes = null,
        string|array|null $statuses = null,
        int|array|null $categoryIds = null,
        int|array|null $colorIds
    ): iterable {
        $uri = $this->uri('inventories', [], [
            'item_types'  => $this->toParam($itemTypes),
            'status'      => $this->toParam($statuses),
            'category_id' => $this->toParam($categoryIds),
            'color_id'    => $this->toParam($colorIds),
        ]);

        $response    = $this->gateway->get($uri);
        $inventories = [];

        foreach ($response['data'] as $inventory) {
            $inventories[] = []; // @todo
        }

        return $inventories;
    }

    public function find(int $id): Inventory
    {
    }

    public function store(Inventory $inventory): Inventory
    {
    }

    public function update(Inventory $inventory): Inventory
    {
    }

    public function delete(Inventory $inventory): bool
    {
        $response = $this->gateway->delete($this->uri('inventories/{inventory_id}', ['inventory_id' => $inventory->id]));

        return $response->isSuccessful();
    }
}
