<?php

namespace Davesweb\BrinklinkApi;

use stdClass;
use Psr\Http\Message\ResponseInterface;
use Davesweb\BrinklinkApi\Exceptions\ConnectionException;

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
        $self->meta       = $asObject ? $self->body->meta : $self->body['meta'];
        $self->statusCode = $asObject ? (int) $self->meta->code : (int) $self->meta['code'];

        if (!isset($self->body->data) && !isset($self->body['data'])) {
            throw new ConnectionException(
                ($asObject ? $self->meta->message : $self->meta['message']).
                ' '.
                ($asObject ? $self->meta->description : $self->meta['description']),
                $self->statusCode
            );
        }

        $self->data = $asObject ? $self->body->data : $self->body['data'];

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

    public function hasData(): bool
    {
        return count($this->data) > 0;
    }
}
