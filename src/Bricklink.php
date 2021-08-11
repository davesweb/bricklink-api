<?php

namespace Davesweb\BrinklinkApi;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\GuzzleException;
use Davesweb\BrinklinkApi\Contracts\BricklinkGateway;
use Davesweb\BrinklinkApi\Exceptions\ResourceException;
use Davesweb\BrinklinkApi\Exceptions\ConnectionException;

class Bricklink implements BricklinkGateway
{
    private BricklinkConfig $config;

    private ClientInterface $client;

    private HandlerStack $stack;

    public function __construct(BricklinkConfig $config, ?ClientInterface $client = null, ?HandlerStack $stack = null)
    {
        $this->config = $config;
        $this->stack  = $stack ?? HandlerStack::create();

        if (null === $stack) {
            $this->stack->push(new Oauth1([
                'consumer_key'    => $this->config->getConsumerKey(),
                'consumer_secret' => $this->config->getConsumerSecret(),
                'token'           => $this->config->getTokenValue(),
                'token_secret'    => $this->config->getTokenSecret(),
            ]));
        }

        $this->client = $client ?? new Client([
            'base_uri' => $this->config->getBaseUri(),
            'handler'  => $this->stack,
            'auth'     => 'oauth',
        ]);
    }

    public function request(string $method, string $uri, array $options = []): BricklinkResponse
    {
        if (count($options) > 0 && !isset($options['body']) && !isset($options['query'])) {
            $keyName = 'GET' === strtoupper($method) || 'HEAD' === strtoupper($method) ? 'query' : 'body';

            $options = [$keyName => $options];
        }

        try {
            $response = $this->client->request($method, $uri, $options);

            $bricklinkResponse = BricklinkResponse::fromResponse($response);

            if (!$bricklinkResponse->isSuccessful() && 404 !== $bricklinkResponse->getStatusCode()) {
                throw ResourceException::fromResponse($bricklinkResponse);
            }

            return $bricklinkResponse;
        } catch (GuzzleException $e) {
            throw ConnectionException::guzzleError($e);
        }
    }

    public function get(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('GET', $uri, $options);
    }

    public function post(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('POST', $uri, $options);
    }

    public function put(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('PUT', $uri, $options);
    }

    public function delete(string $uri, array $options = []): BricklinkResponse
    {
        return $this->request('DELETE', $uri, $options);
    }
}
