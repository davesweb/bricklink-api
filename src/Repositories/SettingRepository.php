<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;
use Davesweb\BrinklinkApi\Transformers\ShippingMethodTransformer;

class SettingRepository extends BaseRepository
{
    public function shippingMethods(): iterable
    {
        $response = $this->gateway->get('/settings/shipping_methods');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = ShippingMethodTransformer::toObject($data);
        }

        return $values;
    }

    public function findShippingMethod(int $id): ?ShippingMethod
    {
        $uri = $this->uri('/settings/shipping_methods/{id}', ['id' => $id]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var ShippingMethod $shippingMethod */
        $shippingMethod = ShippingMethodTransformer::toObject($response->getData());

        return $shippingMethod;
    }
}
