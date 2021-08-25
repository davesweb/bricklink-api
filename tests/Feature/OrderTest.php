<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Cost;
use Davesweb\BrinklinkApi\ValueObjects\Item;
use Davesweb\BrinklinkApi\ValueObjects\Name;
use Davesweb\BrinklinkApi\ValueObjects\Order;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Address;
use Davesweb\BrinklinkApi\ValueObjects\Payment;
use Davesweb\BrinklinkApi\ValueObjects\Feedback;
use Davesweb\BrinklinkApi\ValueObjects\Shipping;
use Davesweb\BrinklinkApi\ValueObjects\OrderItem;
use Davesweb\BrinklinkApi\ValueObjects\OrderMessage;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\ParameterObjects\OrderStatus;
use Davesweb\BrinklinkApi\Repositories\OrderRepository;
use Davesweb\BrinklinkApi\Transformers\OrderTransformer;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;
use Davesweb\BrinklinkApi\Transformers\OrderItemTransformer;
use Davesweb\BrinklinkApi\ParameterObjects\OrderPaymentStatus;
use Davesweb\BrinklinkApi\Transformers\OrderMessageTransformer;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends TestCase
{
    public function testItReturnsOrders(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Order::class, $results[0]);
        $this->assertOrderContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsAnOrder(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->find(1234, false, false, false);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertOrderContent($data, $result);
    }

    public function testItReturnsOrderItems(): void
    {
        $data       = $this->getDataArray('order_item');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $results = $repository->findOrderItems(new Order(orderId: 1234));

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(OrderItem::class, $results[0]);
        $this->assertOrderItemContent($data, $results[0]);
    }

    public function testItReturnsOrderMessages(): void
    {
        $data       = $this->getDataArray('order_message');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $results = $repository->findOrderMessages(new Order(orderId: 1234));

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(OrderMessage::class, $results[0]);
        $this->assertOrderMessageContent($data, $results[0]);
    }

    public function testItReturnsOrderFeedback(): void
    {
        $data       = $this->getDataArray('feedback');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $results = $repository->findOrderFeedback(new Order(orderId: 1234));

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Feedback::class, $results[0]);
        $this->assertOrderFeedbackContent($data, $results[0]);
    }

    public function testItUpdatesAnOrder(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->update(new Order(orderId: 1234));

        $this->assertInstanceOf(Order::class, $result);
        $this->assertOrderContent($data, $result);
    }

    public function testItUpdatesAnOrderStatus(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->updateStatus(new Order(orderId: 1234), OrderStatus::make()->shipped());

        $this->assertTrue($result);
    }

    public function testItUpdatesAnOrderPaymentStatus(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->updatePaymentStatus(new Order(orderId: 1234), OrderPaymentStatus::make()->received());

        $this->assertTrue($result);
    }

    public function testItSendsADriveThru(): void
    {
        $data       = $this->getDataArray('order');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new OrderRepository($gateway, new OrderTransformer(), new OrderItemTransformer(), new OrderMessageTransformer(), new FeedbackTransformer());

        $result = $repository->sendDriveThru(new Order(orderId: 1234), true);

        $this->assertTrue($result);
    }

    protected function assertOrderContent(array $expected, Order $order): void
    {
        $this->assertEquals($expected['order_id'], $order->orderId);
        $this->assertInstanceOf(DateTime::class, $order->dateOrdered);
        $this->assertInstanceOf(DateTime::class, $order->dateStatusChanged);
        $this->assertEquals($expected['seller_name'], $order->sellerName);
        $this->assertEquals($expected['store_name'], $order->storeName);
        $this->assertEquals($expected['buyer_name'], $order->buyerName);
        $this->assertEquals($expected['buyer_email'], $order->buyerEmail);
        $this->assertEquals($expected['require_insurance'], $order->requireInsurance);
        $this->assertEquals($expected['status'], $order->status);
        $this->assertEquals($expected['is_invoiced'], $order->isInvoiced);
        $this->assertEquals($expected['remarks'], $order->remarks);
        $this->assertEquals($expected['total_count'], $order->totalCount);
        $this->assertEquals($expected['unique_count'], $order->uniqueCount);
        $this->assertEquals($expected['total_weight'], $order->totalWeight);
        $this->assertEquals($expected['buyer_order_count'], $order->buyerOrderCount);
        $this->assertEquals($expected['is_filed'], $order->isFiled);
        $this->assertEquals($expected['drive_thru_sent'], $order->driveThruSent);

        $this->assertInstanceOf(Payment::class, $order->payment);
        $this->assertEquals($expected['payment']['method'], $order->payment->method);
        $this->assertEquals($expected['payment']['currency_code'], $order->payment->currencyCode);
        $this->assertEquals($expected['payment']['status'], $order->payment->status);
        $this->assertInstanceOf(DateTime::class, $order->payment->datePaid);

        $this->assertInstanceOf(Shipping::class, $order->shipping);
        $this->assertEquals($expected['shipping']['method_id'], $order->shipping->methodId);
        $this->assertEquals($expected['shipping']['method'], $order->shipping->method);
        $this->assertEquals($expected['shipping']['tracking_link'], $order->shipping->trackingLink);
        $this->assertInstanceOf(Address::class, $order->shipping->address);
        $this->assertEquals($expected['shipping']['address']['full'], $order->shipping->address->full);
        $this->assertEquals($expected['shipping']['address']['country_code'], $order->shipping->address->countryCode);
        $this->assertInstanceOf(Name::class, $order->shipping->address->name);
        $this->assertEquals($expected['shipping']['address']['name']['full'], $order->shipping->address->name->full);

        $this->assertInstanceOf(Cost::class, $order->cost);
        $this->assertEquals($expected['cost']['currency_code'], $order->cost->currencyCode);
        $this->assertEquals($expected['cost']['subtotal'], $order->cost->subtotal);
        $this->assertEquals($expected['cost']['grand_total'], $order->cost->grandTotal);
        $this->assertEquals($expected['cost']['etc1'], $order->cost->etc1);
        $this->assertEquals($expected['cost']['etc2'], $order->cost->etc2);
        $this->assertEquals($expected['cost']['insurance'], $order->cost->insurance);
        $this->assertEquals($expected['cost']['shipping'], $order->cost->shipping);
        $this->assertEquals($expected['cost']['credit'], $order->cost->credit);
        $this->assertEquals($expected['cost']['coupon'], $order->cost->coupon);
        $this->assertEquals($expected['cost']['vat_rate'], $order->cost->vatRate);
        $this->assertEquals($expected['cost']['vat_amount'], $order->cost->vatAmount);

        $this->assertInstanceOf(Cost::class, $order->dispCost);
        $this->assertEquals($expected['disp_cost']['currency_code'], $order->dispCost->currencyCode);
        $this->assertEquals($expected['disp_cost']['subtotal'], $order->dispCost->subtotal);
        $this->assertEquals($expected['disp_cost']['grand_total'], $order->dispCost->grandTotal);
        $this->assertEquals($expected['disp_cost']['etc1'], $order->dispCost->etc1);
        $this->assertEquals($expected['disp_cost']['etc2'], $order->dispCost->etc2);
        $this->assertEquals($expected['disp_cost']['insurance'], $order->dispCost->insurance);
        $this->assertEquals($expected['disp_cost']['shipping'], $order->dispCost->shipping);
        $this->assertEquals($expected['disp_cost']['credit'], $order->dispCost->credit);
        $this->assertEquals($expected['disp_cost']['coupon'], $order->dispCost->coupon);
        $this->assertEquals($expected['disp_cost']['vat_rate'], $order->dispCost->vatRate);
        $this->assertEquals($expected['disp_cost']['vat_amount'], $order->dispCost->vatAmount);
    }

    protected function assertOrderItemContent(array $expected, OrderItem $orderItem): void
    {
        $this->assertEquals($expected['inventory_id'], $orderItem->inventoryId);
        $this->assertInstanceOf(Item::class, $orderItem->item);
        $this->assertEquals($expected['item']['no'], $orderItem->item->number);
        $this->assertEquals($expected['item']['name'], $orderItem->item->name);
        $this->assertEquals($expected['item']['type'], $orderItem->item->type);
        $this->assertEquals($expected['item']['categoryID'], $orderItem->item->categoryId);
        $this->assertEquals($expected['color_id'], $orderItem->colorId);
        $this->assertEquals($expected['quantity'], $orderItem->quantity);
        $this->assertEquals($expected['new_or_used'], $orderItem->newOrUsed);
        $this->assertEquals($expected['completeness'], $orderItem->completeness);
        $this->assertEquals($expected['unit_price'], $orderItem->unitPrice);
        $this->assertEquals($expected['unit_price_final'], $orderItem->unitPriceFinal);
        $this->assertEquals($expected['disp_unit_price'], $orderItem->dispUnitPrice);
        $this->assertEquals($expected['disp_unit_price_final'], $orderItem->dispUnitPriceFinal);
        $this->assertEquals($expected['currency_code'], $orderItem->currencyCode);
        $this->assertEquals($expected['disp_currency_code'], $orderItem->dispCurrencyCode);
        $this->assertEquals($expected['description'], $orderItem->description);
        $this->assertEquals($expected['remarks'], $orderItem->remarks);
    }

    protected function assertOrderMessageContent(array $expected, OrderMessage $orderMessage): void
    {
        $this->assertEquals($expected['subject'], $orderMessage->subject);
        $this->assertEquals($expected['body'], $orderMessage->body);
        $this->assertEquals($expected['from'], $orderMessage->from);
        $this->assertEquals($expected['to'], $orderMessage->to);
        $this->assertInstanceOf(DateTime::class, $orderMessage->dateSent);
    }

    protected function assertOrderFeedbackContent(array $expected, Feedback $orderFeedback): void
    {
        $this->assertEquals($expected['feedback_id'], $orderFeedback->feedbackId);
        $this->assertEquals($expected['order_id'], $orderFeedback->orderId);
        $this->assertEquals($expected['from'], $orderFeedback->from);
        $this->assertEquals($expected['to'], $orderFeedback->to);
        $this->assertInstanceOf(DateTime::class, $orderFeedback->dateRated);
        $this->assertEquals($expected['rating'], $orderFeedback->rating);
        $this->assertEquals($expected['rating_of_bs'], $orderFeedback->ratingOfBs);
        $this->assertEquals($expected['comment'], $orderFeedback->comment);
    }
}
