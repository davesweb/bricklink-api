<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Cost;

class CostTransformer extends BaseTransformer
{
    public string $dto = Cost::class;
}
