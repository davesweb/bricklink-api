<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderProblem;

class OrderProblemTransformer extends BaseTransformer
{
    public static string $dto = OrderProblem::class;

    protected static array $toObject = [];
}
