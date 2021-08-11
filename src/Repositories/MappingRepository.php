<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Mapping;
use Davesweb\BrinklinkApi\Transformers\MappingTransformer;

class MappingRepository extends BaseRepository
{
    public function getElementId(string $number, string $type = 'part', ?int $colorId = null): ?Mapping
    {
        $uri = $this->uri('/item_mapping/{type}/{number}', [
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
        $mapping = MappingTransformer::toObject($response->getData());

        return $mapping;
    }

    public function getItemNumber(string $elementId): ?Mapping
    {
        $uri = $this->uri('/item_mapping/{element_id}', ['element_id' => $elementId]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Mapping $mapping */
        $mapping = MappingTransformer::toObject($response->getData());

        return $mapping;
    }
}
