<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Notification;

class NotificationTransformer extends BaseTransformer
{
    public static string $dto = Notification::class;

    protected static array $toObject = [];
}
