# Configuration

In order to be able to use this package you need an account on [Bricklink](https://bricklink.com). You will also need 
to enable the API for your account. For more information on how to do this, please read the documentation on 
[Bricklink](https://www.bricklink.com/v3/api.page)

## BricklinkConfig

Once you've generated your consumer key and secret and your access tokens you can create a new `BricklinkConfig` object:

```php
<?php

use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret');
```

You can pass the URL to the Bricklink API as the fifth parameter to the constructor:

```php
<?php

use Davesweb\BrinklinkApi\BricklinkConfig;

$config = new BricklinkConfig('consumerKey', 'consumerSecret', 'tokenValue', 'tokenSecret', 'https://api.bricklink.com/api/store/v1');
```

---
<div style="overflow:auto;">
    <div style="float: left;"> </div>
    <div style="float: right;"><a href="gateway.md">Gateway &raquo;</a></div>
</div>