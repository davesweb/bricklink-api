<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Color;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\ColorTransformer;

class ColorRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, ColorTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(): iterable
    {
        $response = $this->gateway->get('colors');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Color
    {
        $response = $this->gateway->get(uri('colors/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Color $color */
        $color = $this->transformer->toObject($response->getData());

        return $color;
    }

    public function findOrFail(int $id): Color
    {
        return $this->find($id) ?? throw NotFoundException::forId($id);
    }
}
