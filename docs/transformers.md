# Transformers & value objects

Transformers are objects that are used to transform the 'raw' API response data to value objects for easy use in your 
own code. Each repository requires one or more transformers.

Value objects are very simple objects that only conist of a few properties which hold the data. Their only goal is to 
pass along the data.

## Default transformers

The default transformers are very simple. Each transformer has a `$dto` property which defines into which value object 
the data is transformed. Each transformer also has an optional `$mapping` property which defines how the data is 
transformed into value objects. For each transformer there is also a value object available in this package. If you 
don't need anything else, but just want to receive the data in a convenient object-oriented way, then you can just use 
the provided transformers and value objects.

If you want to add some more complex logic to your transformers, for instance to transform the data directly into 
you own models instead of the default value objects, you can expand upon the default transformers or write your 
own transformers completely.

## Custom mapping

If you look at the most basic transformer, the `ColorTransformer`, you will see that there is no `$mapping` property 
defined (instead it's defined on the base object, but it has no values). That is because by default every transformer 
transforms the response from the Bricklink API to the same names in the value object, only camel cased.

For instance, if the response of the Bricklink API for a color is something like this:

```json
{
  "color_id": 1,
  "color_name": "White",
  "category": 3,
  "color_type": "Solid"
}
```

This is automatically translated into a value object if it has the same properties as keys in the response, only in 
camel case:

```php
<?php

class Color 
{
    public function __construct(
        public ?int $colorId,
        public ?string $colorName,
        public ?int $category,
        public ?string $colorType,
    ) {}
}
```

If your Transformer object looks like this, the mapping will automatically work:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
}
```

### Custom name

But what if the property in the value object has a name that is not the camel cased version of the same thing in the 
API response? In that case you can provide your own mapping to the transformer. You only need to add custom mappings 
for properties that have different names. If for instance the `$category` property in the value object would be named
`$categoryId`, you can create the following transformer with this custom mapping:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
    
    public array $mapping = [
        'category' => 'categoryId'
    ];
}
```

### Datetime types

By default, the exact value of the API response is stored in the value object property it is mapped to. If you have 
a response property that represents a date and time, you can easily transform this into a `\DateTime` property by adding 
`datetime` as the type in the mapping. 

Let's say we had a `date_created` property in the response of the API for our color, we could add the following 
mapping to transform it into a `\DateTime` object:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
    
    public array $mapping = [
        'category'     => 'categoryId',
        'date_created' => ['dateCreated', 'datetime']
    ];
}
```

As you can see we added an array mapping to our transformer. The first item in the array is the name of the property 
this is mapped to, and the second item is the type, in this case `datetime`. 

### Custom types

If we have a property which value should be mapped in a more complex way and that isn't a `datetime`, you can specify a
transformer as the second parameter. This second parameter should extend the 
`Davesweb\BrinklinkApi\Transformers\BaseTransformer` class and transform the content in the same way as other 
transformers.

Let's say the response doesn't just include a category id, but a complete category object in the response:

```json
{
  "color_id": 1,
  "color_name": "White",
  "color_type": "Solid",
  "category": {
    "id": 3,
    "name": "Solid colors"
  }
}
```

In that case we can create our own ColorCategory transformer that knows how to transform this category to a value 
object:

```php
<?php

class ColorCategoryTransformer
{
    public string $dto = ColorCategory::class;
}
```

And then we can add this custom transformer to our mapping for a color:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
    
    public array $mapping = [
        'category'     => ['category', ColorCategoryTransformer::class],
    ];
}
```

As you can see we again added an array mapping to our transformer. The first item in the array is still the name of the 
property this is mapped to, and the second item is the custom transformer, in this case `ColorCategoryTransformer`.

### Arrays and custom array types

For simple values that are a simple array of values, you may speicify the mapping as an array in the same way as the 
`datetime` mapping:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
    
    public array $mapping = [
        'categories' => ['categoryIds', 'array'],
    ];
}
```

If the array values are of a more complex type and need their own transformers, you can add the transformer as the 
third value in the array:

```php
<?php

class ColorTransformer
{
    public string $dto = Color::class;
    
    public array $mapping = [
        'categories' => ['categories', 'array', ColorCategoryTransformer::class],
    ];
}
```

## Custom transformers

You are off course free to write your own custom transformers. Transformers don't have an interface they have to 
adhere to, instead they are typehinted directly in the repositories. This is because each repository requires 
its own transformer with the correct mapping. So if you want to provide your own transformer for the 
ColorRepository for instance, you'd need to overwrite the `ColorTransformer` and pass along your custom object.

If you want to provide your own transform logic, which is defined in this package by the `BaseTransformer`, you'd 
have to add it to each custom implementation, or maybe use a trait in a smart way.

## Custom value objects

If you want to keep the default mapping of the transformers as it is defined by this package, but you still want to use 
custom value objects, you'd still need to overwrite the transformers as they are.

Say you have a custom `Color` value object that can work with the `ColorTransformer` as it is, you'd still need to 
overwrite the `ColorTransformer` because the value object class name is hardcoded in the `$dto` property:

```php
<?php

class MyColorTransformer
{
    public string $dto = MyCustomColorDTO::class;
}
```

The mapping options will still work the same as in the default `ColorTransformer`. Now you van just pass this new 
`MyColorTransformer` to the `ColorRepository`.

> If you add you own value objects with the default transformer logic, please keep in mind that the value objects 
> are created like this: `$object = new ValueObject(...$values);`. This means that each property should be a 
> parameter in the constructor of your value object, otherwhise you'll get an error like `Unknown named property 'xyz'`.