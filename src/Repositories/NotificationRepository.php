<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\NotificationTransformer;

class NotificationRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, NotificationTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(): iterable
    {
        $response = $this->gateway->get('notifications');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }
}
