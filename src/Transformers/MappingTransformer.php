<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Mapping;

class MappingTransformer extends BaseTransformer
{
    public static string $dto = Mapping::class;

    protected static array $toObject = [];
}
