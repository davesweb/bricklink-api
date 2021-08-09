<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Rating;

class RatingTransformer extends BaseTransformer
{
    public static string $dto = Rating::class;

    protected static array $toObject = [];
}
