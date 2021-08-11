<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Feedback;

class FeedbackTransformer extends BaseTransformer
{
    public static string $dto = Feedback::class;

    protected static array $mapping = [
        'date_rated' => ['dateRated', 'datetime'],
    ];
}
