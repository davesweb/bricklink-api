<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Category;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

class CategoryRepository extends BaseRepository
{
    public function index(): iterable
    {
        $response = $this->gateway->get('categories');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = CategoryTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Category
    {
        $response = $this->gateway->get($this->uri('categories/{id}', ['id' => $id]));

        if (404 === $response->getStatusCode()) {
            return null;
        }

        /** @var Category $category */
        return CategoryTransformer::toObject($response->getData());
    }
}
