<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Note;

class NoteTransformer extends BaseTransformer
{
    public string $dto = Note::class;
}
