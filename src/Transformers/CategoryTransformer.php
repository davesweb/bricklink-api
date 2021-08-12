<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Category;

class CategoryTransformer extends BaseTransformer
{
    public string $dto = Category::class;
}
