<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\ValueObjects\Feedback;
use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\FeedbackRepository;
use Davesweb\BrinklinkApi\Transformers\FeedbackTransformer;

/**
 * @internal
 * @coversNothing
 */
class FeedbackTest extends TestCase
{
    public function testItReturnsIterableIndex(): void
    {
        $data       = $this->getDataArray('feedback');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new FeedbackRepository($gateway, new FeedbackTransformer());

        $results = $repository->index();

        $this->assertIsIterable($results);

        $this->assertGreaterThan(0, count($results));

        $this->assertInstanceOf(Feedback::class, $results[0]);
        $this->assertFeedbackContent($data, $results[0]);
    }

    public function testItReturnsNullWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new FeedbackRepository($gateway, new FeedbackTransformer());

        $result = $repository->find(404);

        $this->assertNull($result);
    }

    public function testItThrowsWhenNothingFound(): void
    {
        $response   = BricklinkResponse::test(404, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new FeedbackRepository($gateway, new FeedbackTransformer());

        $this->expectException(NotFoundException::class);

        $repository->findOrFail(404);
    }

    public function testItReturnsFeedback(): void
    {
        $data       = $this->getDataArray('feedback');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new FeedbackRepository($gateway, new FeedbackTransformer());

        $result = $repository->find(1234);

        $this->assertInstanceOf(Feedback::class, $result);
        $this->assertFeedbackContent($data, $result);
    }

    public function testItStoresFeedback(): void
    {
        $data       = $this->getDataArray('feedback');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new FeedbackRepository($gateway, new FeedbackTransformer());

        $result = $repository->store(new Feedback(feedbackId: 12345));

        $this->assertInstanceOf(Feedback::class, $result);
        $this->assertFeedbackContent($data, $result);
    }

    protected function assertFeedbackContent(array $expected, Feedback $feedback): void
    {
        $this->assertEquals($expected['feedback_id'], $feedback->feedbackId);
        $this->assertEquals($expected['order_id'], $feedback->orderId);
        $this->assertEquals($expected['from'], $feedback->from);
        $this->assertEquals($expected['to'], $feedback->to);
        $this->assertInstanceOf(DateTime::class, $feedback->dateRated);
        $this->assertEquals($expected['rating'], $feedback->rating);
        $this->assertEquals($expected['rating_of_bs'], $feedback->ratingOfBs);
        $this->assertEquals($expected['comment'], $feedback->comment);
    }
}
