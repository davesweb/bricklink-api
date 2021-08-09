<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;

class SettingRepository extends BaseRepository
{
    public function shippingMethods(): iterable
    {
    }

    public function findShippingMethod(int $id): ?ShippingMethod
    {
    }
}
