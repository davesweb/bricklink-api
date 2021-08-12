<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Name;

class NameTransformer extends BaseTransformer
{
    protected string $dto = Name::class;
}
