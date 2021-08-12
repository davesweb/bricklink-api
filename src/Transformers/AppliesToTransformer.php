<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\AppliesTo;

class AppliesToTransformer extends BaseTransformer
{
    public string $dto = AppliesTo::class;
}
