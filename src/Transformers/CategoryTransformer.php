<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Category;

class CategoryTransformer extends BaseTransformer
{
    public static string $dto = Category::class;

    protected static array $toObject = [
        'category_id'   => 'categoryId',
        'category_name' => 'categoryName',
        'parent_id'     => 'parentId',
    ];
}
