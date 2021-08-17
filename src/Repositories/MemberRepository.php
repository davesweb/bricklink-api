<?php

namespace Davesweb\BrinklinkApi\Repositories;

use function Davesweb\uri;
use Davesweb\BrinklinkApi\ValueObjects\Note;
use Davesweb\BrinklinkApi\ValueObjects\Rating;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Transformers\NoteTransformer;
use Davesweb\BrinklinkApi\Transformers\RatingTransformer;

class MemberRepository extends BaseRepository
{
    protected RatingTransformer $ratingTransformer;

    public function __construct(BricklinkGateway $gateway, NoteTransformer $transformer, RatingTransformer $ratingTransformer)
    {
        parent::__construct($gateway, $transformer);

        $this->ratingTransformer = $ratingTransformer;
    }

    public function ratings(string $username): ?Rating
    {
        $uri = uri('/members/{username}/ratings', ['username' => $username]);

        $response = $this->gateway->get($uri);

        if (!$response->hasData()) {
            return null;
        }

        /** @var Rating $result */
        $result = $this->ratingTransformer->toObject($response->getData());

        return $result;
    }

    public function notes(string $username): iterable
    {
        $uri = uri('/members/{username}/notes', ['username' => $username]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = $this->transformer->toObject($data);
        }

        return $values;
    }

    public function storeNote(Note $note): Note
    {
        $uri = uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->post($uri, $this->transformer->toArray($note));

        /** @var Note $newNote */
        $newNote = $this->transformer->toObject($response->getData());

        return $newNote;
    }

    public function updateNote(Note $note): Note
    {
        $uri = uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->put($uri, $this->transformer->toArray($note));

        /** @var Note $newNote */
        $newNote = $this->transformer->toObject($response->getData());

        return $newNote;
    }

    public function deleteNote(Note $note): bool
    {
        $uri = uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->delete($uri);

        return $response->isSuccessful();
    }
}
