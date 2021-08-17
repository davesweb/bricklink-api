<?php

namespace Davesweb\BrinklinkApi\Tests\Feature;

use DateTime;
use Davesweb\BrinklinkApi\Tests\TestCase;
use Davesweb\BrinklinkApi\BricklinkResponse;
use Davesweb\BrinklinkApi\ValueObjects\Note;
use Davesweb\BrinklinkApi\ValueObjects\Rating;
use Davesweb\BrinklinkApi\TestBricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\NoteTransformer;
use Davesweb\BrinklinkApi\Repositories\MemberRepository;
use Davesweb\BrinklinkApi\Transformers\RatingTransformer;

/**
 * @internal
 * @coversNothing
 */
class MemberTest extends TestCase
{
    public function testItReturnsRatings(): void
    {
        $data       = $this->getDataArray('rating');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MemberRepository($gateway, new NoteTransformer(), new RatingTransformer());

        $rating = $repository->ratings('username');

        $this->assertInstanceOf(Rating::class, $rating);
        $this->assertRatingContent($data, $rating);
    }

    public function testItReturnsNotes(): void
    {
        $data       = $this->getDataArray('note');
        $response   = BricklinkResponse::test(200, [$data]);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MemberRepository($gateway, new NoteTransformer(), new RatingTransformer());

        $result = $repository->notes('username');

        $this->assertIsIterable($result);
        $this->assertInstanceOf(Note::class, $result[0]);
        $this->assertNoteContent($data, $result[0]);
    }

    public function testItStoresANote(): void
    {
        $data       = $this->getDataArray('note');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MemberRepository($gateway, new NoteTransformer(), new RatingTransformer());

        $result = $repository->storeNote(new Note(username: 'Username'));

        $this->assertInstanceOf(Note::class, $result);
        $this->assertNoteContent($data, $result);
    }

    public function testItUpdatesANote(): void
    {
        $data       = $this->getDataArray('note');
        $response   = BricklinkResponse::test(200, $data);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MemberRepository($gateway, new NoteTransformer(), new RatingTransformer());

        $result = $repository->updateNote(new Note(noteId: 12345));

        $this->assertInstanceOf(Note::class, $result);
        $this->assertNoteContent($data, $result);
    }

    public function testItDeletesANote(): void
    {
        $response   = BricklinkResponse::test(200, []);
        $gateway    = new TestBricklinkGateway($response);
        $repository = new MemberRepository($gateway, new NoteTransformer(), new RatingTransformer());

        $result = $repository->deleteNote(new Note(noteId: 12345));

        $this->assertTrue($result);
    }

    protected function assertNoteContent(array $expected, Note $note): void
    {
        $this->assertEquals($expected['note_id'], $note->noteId);
        $this->assertEquals($expected['user_name'], $note->username);
        $this->assertEquals($expected['note_text'], $note->text);
        $this->assertInstanceOf(DateTime::class, $note->dateNoted);
    }

    protected function assertRatingContent(array $expected, Rating $rating): void
    {
        $this->assertEquals($expected['user_name'], $rating->username);
        $this->assertIsArray($rating->rating);
        $this->assertEquals($expected['rating']['COMPLAINT'], $rating->rating['COMPLAINT']);
        $this->assertEquals($expected['rating']['PRAISE'], $rating->rating['PRAISE']);
        $this->assertEquals($expected['rating']['NEUTRAL'], $rating->rating['NEUTRAL']);
    }
}
