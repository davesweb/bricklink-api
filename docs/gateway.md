# Gateway

A gateway object is an object that connects with and authenticates you to the Bricklink API. It's also responsible for 
sending requests to the API and processing the responses. This package adds a Bricklink gateway that uses Guzzle under 
the hood for the API requests and authentication, but you are of course free to write your own gateway object if you 
want. If you don't want to write your own gateway object, but you do want more control over the Requests you are 
also free to use your own Guzzle setup (or any other implementation of the PSR-7 specification).

## Bricklink gateway object

This package provides a default `Bricklink` gateway. This gateway requires at least a `BricklinkConfig` object, but 
it can be further customized by adding custom handler stacks or custom clients.

### Custom handler stack

The only thing that is added to the handler stack for the Guzzle Client is the OAuth 1 handler. If you want to add 
more custom options you can specify your own `HandlerStack` to use. If you do so, don't forget to add the OAuth 1 
handler as well, because if you add your own stack then that exact stack is used and this package doesn't add 
the OAuth 1 handler to your custom one.

To create a base stack with the default OAuth 1 handler you can use this code:

```php
<?php

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');

$stack = HandlerStack::create();

$stack->push(new Oauth1([
    'consumer_key'    => $config->getConsumerKey(),
    'consumer_secret' => $config->getConsumerSecret(),
    'token'           => $config->getTokenValue(),
    'token_secret'    => $config->getTokenSecret(),
]));

```

After creating the default stack, you can add your own handlers or middleware to it. To add the logging of each request
for instance, you could use something like this.

> For this example you'll need the [Monolog package](https://github.com/Seldaek/monolog)

```php
<?php

use Monolog\Logger;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use Monolog\Handler\StreamHandler;
use Davesweb\BrinklinkApi\Bricklink;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Davesweb\BrinklinkApi\BricklinkConfig;

// Create the default config and handler stack
$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');

$stack = HandlerStack::create();

$stack->push(new Oauth1([
    'consumer_key'    => $config->getConsumerKey(),
    'consumer_secret' => $config->getConsumerSecret(),
    'token'           => $config->getTokenValue(),
    'token_secret'    => $config->getTokenSecret(),
]));

// Add a logger to log each request
$logger = new Logger('Bricklink API Logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/bricklink-api.log'), Logger::DEBUG);

$stack->push(Middleware::log($logger, new MessageFormatter('{req_body} - {res_body}')));

// Create the gateway with the custom stack
$gateway = new Bricklink(config: $config, stack: $stack);
```

### Custom client

You can also pass along a complete custom object of the `GuzzleHttp\ClientInterface` to the `Bricklink` gateway. If you 
do this, this is the Client object that is used to authenticate and communicate with the Bricklink API. Make sure this 
client can make requests via OAuth 1, as this is the way authentication works with the Bricklink API. 

> When passing along a custom Client object, both the configuration and `HandlerStack` parameters are ignored, even if 
> you add them. When making a request to the Bricklink API, the `baseUrl` from the configuration object is still used 
> as the URL to make requests to.

## Custom Gateway

You are off course free to use a custom gateway object altogether. In that case, simply implement the 
`Davesweb\BrinklinkApi\Contracts\BricklinkGateway` interface and pass that object to the repositories as the gateway 
object. Make sure this gateway object can connect to and communicate with the Bricklink API and all the repositories 
will still work the same.