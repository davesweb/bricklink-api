# Categories

## Fetch all categories

The index method returns an array of all categories.

#### Parameters

> This method has no parameters

#### Return value

Returns an `array` of `Davesweb\BrinklinkApi\ValueObjects\Category()` objects.

#### Example

```php
<?php

use Davesweb\BrinklinkApi\Repositories\CategoryRepository;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

// ... Configuration and gateway objects
$gateway = '...';

$repository = new CategoryRepository($gateway, new CategoryTransformer());

$categories = $repository->index();
```

## Find a category

Find a single category by its Bricklink ID.

#### Parameters

`id` The Bricklink ID of the category to find.

#### Return value

Returns a single `Davesweb\BrinklinkApi\ValueObjects\Category()` if the category is found, or `null` of the category 
is not found.

#### Example

```php
<?php

use Davesweb\BrinklinkApi\Repositories\CategoryRepository;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

// ... Configuration and gateway objects
$gateway = '...';

$repository = new CategoryRepository($gateway, new CategoryTransformer());

$category = $repository->find(1);
```

## Find a category or fail

This method is the same as the `find` method, except it throws a `Davesweb\BrinklinkApi\Exceptions\NotFoundException` 
when the category could not be found instead of returning `null`.

#### Example

```php
<?php

use Davesweb\BrinklinkApi\Exceptions\NotFoundException;
use Davesweb\BrinklinkApi\Repositories\CategoryRepository;
use Davesweb\BrinklinkApi\Transformers\CategoryTransformer;

// ... Configuration and gateway objects
$gateway = '...';

$repository = new CategoryRepository($gateway, new CategoryTransformer());

try {
    $category = $repository->findOrFail(1);
} catch (NotFoundException $e) {
    echo 'Category not found!';
}
```

---
<div style="overflow:auto;">
    <div style="float: left; width: 20%;"><a href="./../repositories.html">&laquo; Repositories</a></div>
    <div style="float: left; width: 60%; text-align: center">
         |
        <a href="colors.html">Colors &rsaquo;</a>
    </div>
    <div style="float: right; width: 20%; text-align: right"><a href="./../laravel.html">Laravel &raquo;</a></div>
</div>