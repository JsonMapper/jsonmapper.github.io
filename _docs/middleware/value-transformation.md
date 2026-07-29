---
permalink: /docs/middleware/value-transformation/  
title: Value Transformation
---

The value transformation middleware can be used to apply a callback to the JSON value before it is mapped to the class property.
 
## Using a php named function as callback
```php
$middleware = new ValueTransformation('srtolower');
$mapper = (new JsonMapperFactory())->bestFit();
$mapper->unshift($middleware);
$object = new User();

$mapper->mapObjectFromString('{ "name": "JOHN DOE" }', $object);

echo $object->getName(); // "john doe"
```

## Using a custom callback
```php
$middleware = new ValueTransformation(
    static function ($key, $value) {
        if ($key === 'name') {
            return \base64_decode($value);
        }

        return $value;
    },
    true
);
$mapper = (new JsonMapperFactory())->bestFit();
$mapper->unshift($middleware);
$object = new User();

$mapper->mapObjectFromString('{ "name": "Sm9obiBEb2U=" }', $object);

echo $object->getName(); // "John Doe"
```