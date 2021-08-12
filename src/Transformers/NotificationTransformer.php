<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Notification;

class NotificationTransformer extends BaseTransformer
{
    public string $dto = Notification::class;

    protected array $mapping = [
        'timestamp' => ['timestamp', 'datetime'],
    ];
}
