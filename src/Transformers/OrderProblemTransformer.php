<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderProblem;

class OrderProblemTransformer extends BaseTransformer
{
    public string $dto = OrderProblem::class;
}
