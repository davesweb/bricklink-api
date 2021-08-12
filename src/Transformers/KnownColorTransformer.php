<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\KnownColor;

class KnownColorTransformer extends BaseTransformer
{
    public string $dto = KnownColor::class;
}
