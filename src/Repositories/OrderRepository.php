<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Order;
use Davesweb\BrinklinkApi\Transformers\OrderTransformer;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;
use Davesweb\BrinklinkApi\Transformers\OrderItemTransformer;
use Davesweb\BrinklinkApi\Transformers\OrderMessageTransformer;

class OrderRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    public function index(string $direction = self::DIRECTION_IN, string|array|null $statuses = null, bool $filed = false): iterable
    {
        $uri = $this->uri('orders', [], [
            'direction' => $direction,
            'status'    => $this->toParam($statuses),
            'filed'     => $filed ? 'true' : 'false',
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = OrderTransformer::toObject($data);
        }

        return $values;
    }

    public function find(int $id, bool $withItems = true, bool $withMessages = false, bool $withFeedback = false): ?Order
    {
        $response = $this->gateway->get($this->uri('orders/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Order $order */
        $order = OrderTransformer::toObject($response->getData());

        if ($withItems) {
            $order->items = $this->findOrderItems($order);
        }

        if ($withMessages) {
            $order->messages = $this->findOrderMessages($order);
        }

        if ($withFeedback) {
            $order->feedback[] = $this->findOrderFeedback($order);
        }

        return $order;
    }

    public function findOrderItems(Order $order): iterable
    {
        $itemsResponse = $this->gateway->get($this->uri('orders/{id}/items', ['id' => $order->orderId]));

        $items = [];

        foreach ($itemsResponse->getData() as $data) {
            $items[] = OrderItemTransformer::toObject($data);
        }

        return $items;
    }

    public function findOrderMessages(Order $order): iterable
    {
        $messagesResponse = $this->gateway->get($this->uri('orders/{id}/messages', ['id' => $order->orderId]));

        $messages = [];

        foreach ($messagesResponse->getData() as $data) {
            $messages[] = OrderMessageTransformer::toObject($data);
        }

        return $messages;
    }

    public function findOrderFeedback(Order $order): iterable
    {
        $feedbackResponse = $this->gateway->get($this->uri('orders/{id}/feedback', ['id' => $order->orderId]));

        $feedback = [];

        foreach ($feedbackResponse->getData() as $data) {
            $feedback[] = FeedbackTransformer::toObject($data);
        }

        return $feedback;
    }

    public function update(Order $order): Order
    {
        $response = $this->gateway->put(
            $this->uri('orders/{id}', ['id' => $order->orderId]),
            OrderTransformer::toArray($order)
        );

        /** @var Order $updatedOrder */
        $updatedOrder = OrderTransformer::toObject($response->getData());

        return $updatedOrder;
    }

    public function updateStatus(Order $order, string $newStatus): bool
    {
        $response = $this->gateway->put(
            $this->uri('/orders/{id}/status', ['id' => $order->orderId]),
            ['field' => 'status', 'value' => $newStatus],
        );

        return $response->isSuccessful();
    }

    public function updatePaymentStatus(Order $order, string $newStatus): bool
    {
        $response = $this->gateway->put(
            $this->uri('/orders/{id}/status', ['id' => $order->orderId]),
            ['field' => 'payment_status', 'value' => $newStatus],
        );

        return $response->isSuccessful();
    }

    public function sendDriveThru(Order $order, bool $mailMe = false): bool
    {
        $uri = $this->uri(
            '/orders/{id}/drive_thru',
            ['id' => $order->orderId],
            ['mail_me', $mailMe ? 'true' : 'false'],
        );

        $response = $this->gateway->post($uri);

        return $response->isSuccessful();
    }
}
