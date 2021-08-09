<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderMessage;

class OrderMessageTransformer extends BaseTransformer
{
    public static string $dto = OrderMessage::class;

    protected static array $toObject = [];
}
