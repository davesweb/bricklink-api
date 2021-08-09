<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Order;

class OrderRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_IN, array $statuses = [], bool $filed = false): iterable
    {
    }

    public function find(int $id): ?Order
    {
    }

    public function update(Order $order): Order
    {
    }

    public function updateStatus(Order $order, string $newStatus): bool
    {
    }

    public function updatePaymentStatus(Order $order, string $newStatus): bool
    {
    }

    public function sendDriveThru(Order $order): bool
    {
    }
}
