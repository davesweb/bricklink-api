<?php

namespace Davesweb\BrinklinkApi;

use stdClass;
use Psr\Http\Message\ResponseInterface;

class BricklinkResponse
{
    private int $statusCode;

    private array|stdClass $meta;

    private array|stdClass $body;

    private array|stdClass $data;

    public static function fromResponse(ResponseInterface $response, bool $asObject = false): static
    {
        $self = new static();

        $self->body       = json_decode($response->getBody()->getContents(), !$asObject);
        $self->data       = $asObject ? $self->body->data : $self->body['data'];
        $self->meta       = $asObject ? $self->body->meta : $self->body['meta'];
        $self->statusCode = $asObject ? (int) $self->meta->code : (int) $self->meta['code'];

        return $self;
    }

    public static function test(int $statusCode, array $data, array $meta = []): static
    {
        $self = new static();

        $self->body       = [];
        $self->statusCode = $statusCode;
        $self->data       = $data;
        $self->meta       = $meta;

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

    public function getData(): array|stdClass
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
