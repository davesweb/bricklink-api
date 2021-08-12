<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\ShippingMethod;
use Davesweb\BrinklinkApi\Transformers\ShippingMethodTransformer;

class SettingRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, ShippingMethodTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function shippingMethods(): iterable
    {
        $response = $this->gateway->get('/settings/shipping_methods');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function findShippingMethod(int $id): ?ShippingMethod
    {
        $uri = uri('/settings/shipping_methods/{id}', ['id' => $id]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var ShippingMethod $shippingMethod */
        $shippingMethod = $this->transformer->toObject($response->getData());

        return $shippingMethod;
    }
}
