# Bricklink API

A PHP SDK for the Bricklink API. This package provides an easy way to authenticate with the Bricklink API, so you can run 
requests directly against the Bricklink API. This package also provides some repositories for easier and object-oriented 
communication with the Bricklink API.

This package is still in an Alpha version, not every API call is tested. Use at your own risk for now.

## Installation

`composer require davesweb/bricklink-api`

## Usage

The following examples are just the basic usage of how to set up this package. Please read the 
[complete documentation](https://davesweb.github.io/bricklink-api/) for more detailed and advanced examples of how to 
use this package and how to extend this package.

### Authentication

First, create a config object with your secrets and tokens you got from Bricklink.

```php
<?php

use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');
```

Optionally you may pass the API URL as a fifth parameter in case this ever changes, but by default this is set 
correctly.

Next create a Bricklink Gateway object with the config you just made.

```php
<?php

use Davesweb\BrinklinkApi\Bricklink;
use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');

$gateway = new Bricklink($config);
```

You can now call the `request()` method on the gateway object to make direct requests to your shop. However you can also
use the repositories for easier data manipulation.

### Repositories

This package provides a set of repositories that mimic the API structure of Bricklink. There are 14 repositories you can use:

- `CategoryRepository`
- `ColorRepository`
- `CouponRepository`
- `FeedbackRepository`
- `InventoryRepository`
- `ItemRepository`
- `MappingRepository`
- `MemberRepository`
- `NotificationRepository`
- `OrderRepository`
- `PriceGuideRepository`
- `SettingRepository`
- `SubsetRepository`
- `SupersetRepoository`

Each repository requires a `Gateway` object to connect to Bricklink, and a `Transformer` object to transform the raw 
data into value objects. Some repositories may require multiple transformers because they transform multiple things, 
like the `OrderRepository`. A simple example is:

```php
<?php

use Davesweb\BrinklinkApi\Bricklink;
use Davesweb\BrinklinkApi\BricklinkConfig;
use Davesweb\BrinklinkApi\Repositories\ColorRepository;
use Davesweb\BrinklinkApi\Transformers\ColorTransformer;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');
$gateway = new Bricklink($config);

$repository = new ColorRepository($gateway, new ColorTransformer());

$color = $repository->find(1);

var_dump($color);
```

## Documentation

Please read the [documentation](https://davesweb.github.io/bricklink-api/) for more detailed and advanced examples 
of how to use this package.

## Docker

This package contains a Docker setup te easily run the tests and CS fixer.

To build the docker image, copy the docker compose file:

`cp docker-compose.yml.dist docker-compose.yml`

Then run:

`docker-compose build`

To start the container, run: 

`docker-compose up -d`

Logging in to the docker container:

`docker-compose exec app bash`

## Tests

To run the test suite, run `composer test` from inside the docker container, or `docker-compose exec app composer test` 
from outside the docker container. Tests are created using PHPUnit, so you may use PHPUnit and it's options directly to 
run the tests.

## CS Fixer

To run CS fixer on the entire project, run `composer cs-fixer` from inside the container, or 
`docker-compose exec app composer cs-fixer` from outside the docker container. You can also run CS fixer directly 
(`php vendor/bin/php-cs-fixer fix`) and add your custom arguments. Keep in mind that the contributing guide 
requires you to run CS Fixer with the configuration in this package.

## Roadmap

These features/enhancements will be added in future releases:

- Support for PHP 8.1.
- ~~Validate the values on parameters.~~ ✔️
- Finish documentation about repositories.
- ~~Add docker setup for local development.~~ ✔️

## License

This package is licensed under the MIT license, which basically means you can do whatever your want with this package. However, if you found this package useful, please consider buying me a beer or subscribing to premium email support over on [Patreon](https://www.patreon.com/davesweb), it's really appreciated!
