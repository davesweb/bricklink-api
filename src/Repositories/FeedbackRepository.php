<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Feedback;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;

class FeedbackRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_IN): iterable
    {
        $uri = $this->uri('feedback', [], ['direction' => $direction]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = FeedbackTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Feedback
    {
        $response = $this->gateway->get($this->uri('/feedback/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Feedback $feedback */
        $feedback = FeedbackTransformer::toObject($response->getData());

        return $feedback;
    }

    public function store(Feedback $feedback): Feedback
    {
        $response = $this->gateway->post('feedback', FeedbackTransformer::toArray($feedback));

        /** @var Feedback $newFeedback */
        $newFeedback = FeedbackTransformer::toObject($response->getData());

        return $newFeedback;
    }

    public function reply(int $toId, Feedback $feedback): bool
    {
        $response = $this->gateway->post($this->uri('/feedback/{id}/reply', ['id' => $toId]), FeedbackTransformer::toArray($feedback));

        return $response->isSuccessful();
    }
}
