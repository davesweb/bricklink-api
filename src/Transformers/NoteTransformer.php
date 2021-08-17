<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Note;

class NoteTransformer extends BaseTransformer
{
    public string $dto = Note::class;

    protected array $mapping = [
        'user_name'  => 'username',
        'note_text'  => 'text',
        'date_noted' => ['dateNoted', 'datetime'],
    ];
}
