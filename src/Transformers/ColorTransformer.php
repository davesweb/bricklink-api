<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Color;

class ColorTransformer extends BaseTransformer
{
    public string $dto = Color::class;
}
