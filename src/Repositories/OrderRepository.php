<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use function Davesweb\toString;
use Davesweb\BrinklinkApi\Enums\Direction;
use Davesweb\BrinklinkApi\Enums\OrderStatus;
use Davesweb\BrinklinkApi\ValueObjects\Order;
use Davesweb\BrinklinkApi\Enums\OrderPaymentStatus;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Transformers\OrderTransformer;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;
use Davesweb\BrinklinkApi\Transformers\OrderItemTransformer;
use Davesweb\BrinklinkApi\Transformers\OrderMessageTransformer;

class OrderRepository extends BaseRepository
{
    public const DIRECTION_IN  = 'in';
    public const DIRECTION_OUT = 'out';

    protected OrderItemTransformer $itemTransformer;

    protected OrderMessageTransformer $messageTransformer;

    protected FeedbackTransformer $feedbackTransformer;

    public function __construct(
        BricklinkGateway $gateway,
        OrderTransformer $transformer,
        OrderItemTransformer $itemTransformer,
        OrderMessageTransformer $messageTransformer,
        FeedbackTransformer $feedbackTransformer,
    ) {
        parent::__construct($gateway, $transformer);

        $this->itemTransformer     = $itemTransformer;
        $this->messageTransformer  = $messageTransformer;
        $this->feedbackTransformer = $feedbackTransformer;
    }

    public function index(?Direction $direction = null, ?OrderStatus $statuses = null, bool $filed = false): iterable
    {
        $uri = uri('orders', [], [
            'direction' => toString($direction, Direction::default()),
            'status'    => toString($statuses, OrderStatus::default()),
            'filed'     => $filed ? 'true' : 'false',
        ]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function find(int $id, bool $withItems = true, bool $withMessages = false, bool $withFeedback = false): ?Order
    {
        $response = $this->gateway->get(uri('orders/{id}', ['id' => $id]));

        if (!$response->hasData()) {
            return null;
        }

        /** @var Order $order */
        $order = $this->transformer->toObject($response->getData());

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

    public function findOrFail(int $id, bool $withItems = true, bool $withMessages = false, bool $withFeedback = false): Order
    {
        return $this->find($id, $withItems, $withMessages, $withFeedback) ?? throw NotFoundException::forId($id);
    }

    public function findOrderItems(Order $order): iterable
    {
        $itemsResponse = $this->gateway->get(uri('orders/{id}/items', ['id' => $order->orderId]));

        $items = [];

        foreach ($itemsResponse->getData() as $data) {
            $items[] = $this->itemTransformer->toObject($data);
        }

        return $items;
    }

    public function findOrderMessages(Order $order): iterable
    {
        $messagesResponse = $this->gateway->get(uri('orders/{id}/messages', ['id' => $order->orderId]));

        $messages = [];

        foreach ($messagesResponse->getData() as $data) {
            $messages[] = $this->messageTransformer->toObject($data);
        }

        return $messages;
    }

    public function findOrderFeedback(Order $order): iterable
    {
        $feedbackResponse = $this->gateway->get(uri('orders/{id}/feedback', ['id' => $order->orderId]));

        $feedback = [];

        foreach ($feedbackResponse->getData() as $data) {
            $feedback[] = $this->feedbackTransformer->toObject($data);
        }

        return $feedback;
    }

    public function update(Order $order): Order
    {
        $response = $this->gateway->put(
            uri('orders/{id}', ['id' => $order->orderId]),
            $this->transformer->toArray($order)
        );

        /** @var Order $updatedOrder */
        $updatedOrder = $this->transformer->toObject($response->getData());

        return $updatedOrder;
    }

    public function updateStatus(Order $order, OrderStatus $newStatus): bool
    {
        $response = $this->gateway->put(
            uri('/orders/{id}/status', ['id' => $order->orderId]),
            ['field' => 'status', 'value' => (string) $newStatus],
        );

        return $response->isSuccessful();
    }

    public function updatePaymentStatus(Order $order, OrderPaymentStatus $newStatus): bool
    {
        $response = $this->gateway->put(
            uri('/orders/{id}/status', ['id' => $order->orderId]),
            ['field' => 'payment_status', 'value' => (string) $newStatus],
        );

        return $response->isSuccessful();
    }

    public function sendDriveThru(Order $order, bool $mailMe = false): bool
    {
        $uri = uri(
            '/orders/{id}/drive_thru',
            ['id' => $order->orderId],
            ['mail_me', $mailMe ? 'true' : 'false'],
        );

        $response = $this->gateway->post($uri);

        return $response->isSuccessful();
    }
}
