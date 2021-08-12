<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Mapping;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\MappingTransformer;

class MappingRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, MappingTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function getElementId(string $number, string $type = 'part', ?int $colorId = null): ?Mapping
    {
        $uri = uri('/item_mapping/{type}/{number}', [
            'type'   => $type,
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
