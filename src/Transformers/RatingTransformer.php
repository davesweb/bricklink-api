<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Rating;

class RatingTransformer extends BaseTransformer
{
    public string $dto = Rating::class;

    protected array $mapping = [
        'user_name' => 'username',
        'rating'    => ['rating', 'array'],
    ];
}
