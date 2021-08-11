<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Order;

class OrderTransformer extends BaseTransformer
{
    public static string $dto = Order::class;

    protected static array $mapping = [
        'date_ordered'        => ['dateOrdered', 'datetime'],
        'date_status_changed' => ['dateStatusChanged', 'datetime'],
        'payment'             => ['payment', PaymentTransformer::class],
        'shipping'            => ['shipping', ShippingTransformer::class],
        'cost'                => ['cost', CostTransformer::class],
        'disp_cost'           => ['dispCost', CostTransformer::class],
    ];
}
