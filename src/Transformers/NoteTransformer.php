<?php

namespace Davesweb\BrinklinkApi\Transformers;

use Davesweb\BrinklinkApi\ValueObjects\Note;

class NoteTransformer extends BaseTransformer
{
    public static string $dto = Note::class;

    protected static array $toObject = [];
}
