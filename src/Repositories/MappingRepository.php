<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\ValueObjects\Mapping;
use Davesweb\BrinklinkApi\ParameterObjects\ItemType;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\MappingTransformer;

class MappingRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, MappingTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function getElementId(string $number, ?ItemType $type = null, ?int $colorId = null): ?Mapping
    {
        $uri = uri('/item_mapping/{type}/{number}', [
            'type'   => toString($type, ItemType::default()),
            'number' => $number,
        ], [
            'color_id' => $colorId,
        ]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Mapping $mapping */
        $mapping = $this->transformer->toObject($response->getData());

        return $mapping;
    }

    public function getItemNumber(string $elementId): ?Mapping
    {
        $uri = uri('/item_mapping/{element_id}', ['element_id' => $elementId]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Mapping $mapping */
        $mapping = $this->transformer->toObject($response->getData());

        return $mapping;
    }
}
