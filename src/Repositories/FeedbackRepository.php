<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Feedback;

class FeedbackRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_IN): iterable
    {
    }

    public function find(int $id): ?Feedback
    {
    }

    public function store(Feedback $feedback): Feedback
    {
    }

    public function reply(int $toId, Feedback $feedback): bool
    {
    }
}
