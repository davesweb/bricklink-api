<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\Transformers\NotificationTransformer;

class NotificationRepository extends BaseRepository
{
    public function index(): iterable
    {
        $response = $this->gateway->get('notifications');

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = NotificationTransformer::toObject($data);
        }

        return $values;
    }
}
