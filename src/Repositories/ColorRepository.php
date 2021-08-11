<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Color;
use Davesweb\BrinklinkApi\Transformers\ColorTransformer;

class ColorRepository extends BaseRepository
{
    public function index(): iterable
    {
        $response = $this->gateway->get('colors');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = ColorTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Color
    {
        $response = $this->gateway->get($this->uri('colors/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Color $color */
        $color = ColorTransformer::toObject($response->getData());

        return $color;
    }
}
