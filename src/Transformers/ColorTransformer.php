<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Color;

class ColorTransformer extends BaseTransformer
{
    public static string $dto = Color::class;
}
