<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Note;
use Davesweb\BrinklinkApi\Transformers\NoteTransformer;
use Davesweb\BrinklinkApi\Transformers\RatingTransformer;

class MemberRepository extends BaseRepository
{
    public function ratings(string $username): iterable
    {
        $uri = $this->uri('/members/{username}/ratings', ['username' => $username]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = RatingTransformer::toObject($data);
        }

        return $values;
    }

    public function notes(string $username): iterable
    {
        $uri = $this->uri('/members/{username}/notes', ['username' => $username]);

        $response = $this->gateway->get($uri);

        $values = [];

        foreach ($response->getData() as $data) {
            $values[] = NoteTransformer::toObject($data);
        }

        return $values;
    }

    public function storeNote(Note $note): Note
    {
        $uri = $this->uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->post($uri, NoteTransformer::toArray($note));

        /** @var Note $newNote */
        $newNote = NoteTransformer::toObject($response->getData());

        return $newNote;
    }

    public function updateNote(Note $note): Note
    {
        $uri = $this->uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->put($uri, NoteTransformer::toArray($note));

        /** @var Note $newNote */
        $newNote = NoteTransformer::toObject($response->getData());

        return $newNote;
    }

    public function deleteNote(Note $note): bool
    {
        $uri = $this->uri('/members/{username}/notes', ['username' => $note->username]);

        $response = $this->gateway->delete($uri);

        return $response->isSuccessful();
    }
}
