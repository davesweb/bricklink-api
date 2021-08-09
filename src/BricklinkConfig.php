<?php

namespace Davesweb\BrinklinkApi;

class BricklinkConfig
{
    private string $consumerKey;
    private string $consumerSecret;
    private string $tokenValue;
    private string $tokenSecret;
    private string $baseUri;

    public function __construct(
        string $consumerKey,
        string $consumerSecret,
        string $tokenValue,
        string $tokenSecret,
        string $baseUri = 'https://api.bricklink.com/api/store/v1/',
    ) {
        $this->consumerKey    = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->tokenValue     = $tokenValue;
        $this->tokenSecret    = $tokenSecret;
        $this->baseUri        = $baseUri;
    }

    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }

    public function getConsumerSecret(): string
    {
        return $this->consumerSecret;
    }

    public function getTokenValue(): string
    {
        return $this->tokenValue;
    }

    public function getTokenSecret(): string
    {
        return $this->tokenSecret;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
