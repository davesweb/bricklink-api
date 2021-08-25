<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Feedback;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\ParameterObjects\Direction;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;

class FeedbackRepository extends BaseRepository
{
    public function __construct(BricklinkGateway $gateway, FeedbackTransformer $transformer)
    {
        parent::__construct($gateway, $transformer);
    }

    public function index(?Direction $direction = null): iterable
    {
        $uri = uri('feedback', [], ['direction' => $direction ? (string) $direction : (string) Direction::default()]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id): ?Feedback
    {
        $response = $this->gateway->get(uri('/feedback/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Feedback $feedback */
        $feedback = $this->transformer->toObject($response->getData());

        return $feedback;
    }

    public function findOrFail(int $id): Feedback
    {
        return $this->find($id) ?? throw NotFoundException::forId($id);
    }

    public function store(Feedback $feedback): Feedback
    {
        $response = $this->gateway->post('feedback', $this->transformer->toArray($feedback));

        /** @var Feedback $newFeedback */
        $newFeedback = $this->transformer->toObject($response->getData());

        return $newFeedback;
    }

    public function reply(int $toId, Feedback $feedback): bool
    {
        $response = $this->gateway->post(uri('/feedback/{id}/reply', ['id' => $toId]), $this->transformer->toArray($feedback));

        return $response->isSuccessful();
    }
}
