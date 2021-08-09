<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Note;
use Davesweb\BrinklinkApi\ValueObjects\Rating;

class MemberRepository extends BaseRepository
{
    public function ratings(string $username): ?Rating
    {
    }

    public function notes(string $username): iterable
    {
    }

    public function storeNote(Note $note): Note
    {
    }

    public function updateNote(Note $note): Note
    {
    }

    public function deleteNote(Note $note): bool
    {
    }
}
