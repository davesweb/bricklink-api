<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Feedback;

class FeedbackTransformer extends BaseTransformer
{
    public string $dto = Feedback::class;

    protected array $mapping = [
        'date_rated' => ['dateRated', 'datetime'],
    ];
}
