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

This package provides a set of repositories that mimic the API structure of Bricklink. There are 11 repositories you can use:

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
- `SettingRepository`

Each repository requires a `Gateway` object to connect to Bricklink:

```php
<?php

use Davesweb\BrinklinkApi\Bricklink;
use Davesweb\BrinklinkApi\BricklinkConfig;
use Davesweb\BrinklinkApi\Repositories\ItemRepository;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');
$gateway = new Bricklink($config);

$repository = new ItemRepository($gateway);

$item = $repository->find('3001', 'part');

var_dump($item);
```

For a detailed documentation of each repository and it's method please see the docs section of the repository (or just look at the code :P, the method signatures are pretty straightforward).

### Advanced usage
1. Custom client or Handlerstack

## Tests

To run the test suite, run `composer test`. Tests are created using PHPUnit, so you may use PHPUnit and it's options
directly to run the tests.

## Contributing

When contributing to this project, please make sure PHP CS fixer is run before you create a pull request. You can run CS fixer on the entire project by running `composer cs-fixer`.

## Roadmap

These features/enhancements will be added in future releases:

- Add `findOrFail` methods to each repository that has a `find` method. These will throw an exception when there is no result instead of returning `NULL`.
- Change the static methods and properties in the transformers to normal methods and properties and use dependency injection for using them in the repositories. This will allow them to be overwritten by the end user if needed.
- Implement own versions for the `Str::snakeCase()` and `Str::camelCase()` methods, so we can remove the dependency on `illuminate/support`. That package adds too much that we don't use.
