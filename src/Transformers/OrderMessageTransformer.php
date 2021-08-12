<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\OrderMessage;

class OrderMessageTransformer extends BaseTransformer
{
    public string $dto = OrderMessage::class;

    protected array $mapping = [
        'dateSent' => ['dateSent', 'datetime'],
    ];
}
