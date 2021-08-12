<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Category;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

class CategoryRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, CategoryTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(): iterable
    {
        $response = $this->gateway->get('categories');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Category
    {
        $response = $this->gateway->get(uri('categories/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Category $category */
        $category = $this->transformer->toObject($response->getData());

        return $category;
    }

    public function findOrFail(int $id): Category
    {
        return $this->find($id) ?? throw NotFoundException::forId($id);
    }
}
