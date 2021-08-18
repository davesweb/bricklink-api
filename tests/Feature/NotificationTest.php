<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Notification;
use Davesweb\BrinklinkApi\Repositories\NotificationRepository;
use Davesweb\BrinklinkApi\Transformers\NotificationTransformer;

/**
 * @internal
 * @coversNothing
 */
class NotificationTest extends TestCase
{
    public function testItReturnsNotifications(): void
    {
        $data       = $this->getDataArray('notification');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new NotificationRepository($gateway, new NotificationTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Notification::class, $results[0]);
        $this->assertNotificationContent($data, $results[0]);
    }

    protected function assertNotificationContent(array $expected, Notification $notification): void
    {
        $this->assertEquals($expected['event_type'], $notification->eventType);
        $this->assertEquals($expected['resource_id'], $notification->resourceId);
        $this->assertInstanceOf(DateTime::class, $notification->timestamp);
    }
}
