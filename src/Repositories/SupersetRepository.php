<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\Enums\ItemType;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\SupersetTransformer;

class SupersetRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, SupersetTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(string $number, ?ItemType $type = null, ?int $colorId = null): iterable
    {
        $uri = uri('/items/{type}/{number}/supersets', [
            'type'     => toString($type, ItemType::default()),
            'number'   => $number,
            'color_id' => $colorId,
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }
}
