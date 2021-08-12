<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Payment;

class PaymentTransformer extends BaseTransformer
{
    public string $dto = Payment::class;

    protected array $mapping = [
        'date_paid' => ['datePaid', 'datetime'],
    ];
}
