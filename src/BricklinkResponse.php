<?php

namespace Davesweb\BrinklinkApi;

use stdClass;
use Psr\Http\Message\ResponseInterface;

class BricklinkResponse
{
    private int $statusCode;

    private array|stdClass $meta;

    private array|stdClass $body;

    public static function fromResponse(ResponseInterface $response, bool $asObject = false): static
    {
        $self = new static();

        $self->meta = (array) $response->getBody()->getMetadata();
        $self->body = json_decode($response->getBody()->getContents(), !$asObject);

        return $self;
    }

    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function getBody(): array|stdClass
    {
        return $this->body;
    }

    public function getMeta(): array|stdClass
    {
        return $this->meta;
    }
}
