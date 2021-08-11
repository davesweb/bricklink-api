<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Payment;

class PaymentTransformer extends BaseTransformer
{
    public static string $dto = Payment::class;

    protected static array $mapping = [
        'date_paid' => ['datePaid', 'datetime'],
    ];
}
