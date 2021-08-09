<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Category;

class CategoryRepository extends BaseRepository
{
    public function index(): iterable
    {
        return [];
    }

    public function find(int $id): ?Category
    {
    }
}
