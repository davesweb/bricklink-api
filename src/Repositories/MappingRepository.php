<?php

namespace Davesweb\BrinklinkApi\Repositories;

use Davesweb\BrinklinkApi\ValueObjects\Mapping;

class MappingRepository extends BaseRepository
{
    public function getElementId(string $number, string $type = 'part'): ?Mapping
    {
    }

    public function getItemNumber(string $elementId): ?Mapping
    {
    }
}
