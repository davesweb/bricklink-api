<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\Enums\ItemType;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\SubsetTransformer;

class SubsetRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, SubsetTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(
        string $number,
        ?ItemType $type = null,
        ?int $colorId = null,
        ?bool $box = null,
        ?bool $instruction = null,
        ?bool $breakMinifigs = null,
        ?bool $breakSubsets = null,
    ): iterable {
        $uri = uri('/items/{type}/{number}/subsets', [
            'type'   => $type ? (string) $type : ItemType::default(),
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
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }
}
