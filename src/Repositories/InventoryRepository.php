<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\ParameterObjects\Id;
use Davesweb\BrinklinkApi\ValueObjects\Inventory;
use Davesweb\BrinklinkApi\ParameterObjects\ItemType;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\ParameterObjects\InventoryStatus;
use Davesweb\BrinklinkApi\Transformers\InventoryTransformer;

class InventoryRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, InventoryTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(
        ?ItemType $itemTypes = null,
        ?InventoryStatus $status = null,
        ?Id $categoryIds = null,
        ?Id $colorIds = null
    ): iterable {
        $uri = uri('inventories', [], [
            'item_type'  => toString($itemTypes, ItemType::default()),
            'status'      => toString($status, InventoryStatus::default()),
            'category_id' => toString($categoryIds, Id::default()),
            'color_id'    => toString($colorIds, Id::default()),
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
