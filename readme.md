# Bricklink API

A PHP SDK for the Bricklink API. This package provides an easy way to authenticate with the Bricklink API, so you can run 
requests directly against the Bricklink API. This package also provides some repositories for easier and object-oriented 
communication with the Bricklink API.

This package is still in an Alpha version, not every API call is tested. Use at your own risk for now.

## Installation

`composer require davesweb/bricklink-api`

## Usage

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

For a detailed documentation of each repository and it's method please see the docs section of the repository (or just look at the code :P, the method signatures are pretty straightforward).

### Advanced usage
1. Custom client or Handlerstack @todo

## Tests

To run the test suite, run `composer test`. Tests are created using PHPUnit, so you may use PHPUnit and it's options
directly to run the tests.

## CS Fixer

To run CS fixer on the entire project, run `composer cs-fixer`.

## Roadmap

These features/enhancements will be added in future releases:

- ~~Add `findOrFail` methods to each repository that has a `find` method. These will throw an exception when there is no result instead of returning `NULL`.~~ ✔️
- ~~Change the static methods and properties in the transformers to normal methods and properties and use dependency injection for using them in the repositories. This will allow them to be overwritten by the end user if needed.~~ ✔️
- ~~Implement own versions for the `Str::snakeCase()` and `Str::camelCase()` methods, so we can remove the dependency on `illuminate/support`. That package adds too much that we don't use.~~ ✔️
- Split up repositories that use more than one Transformer, they obviously don't belong together. `OrderRepository` is an exception to this, but the transformers for all these should be combined into one transformer.

## License

This package is licensed under the MIT license, which basically means you can do whatever your want with this package. However, if you found this package useful, please consider buying me a beer or subscribing to premium email support over on [Patreon](https://www.patreon.com/davesweb), it's really appreciated!
