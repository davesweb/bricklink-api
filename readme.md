# Installation

`composer require davesweb/bricklink-api`

# Usage

First, create a config object with your secrets and tokens you got from Bricklink.

```php
<?php

use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');

//...
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

//...
```

You can now call the `request()` method on the gateway object to make direct requests to your shop. However you can also
use the repositories for easier data manipulation.

# Repositories

# Advanced usage
1. Custom client or Handlerstack

# Tests

To run the test suite, run `composer test`. Tests are created using PHPUnit, so you may use PHPUnit and it's options
directly to run the tests.