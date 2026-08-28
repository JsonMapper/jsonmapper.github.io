---
title: Value Transformation
---

# Value Transformation

The value transformation middleware can be used to apply a callback to the JSON value before it is mapped to the class property.

_Available since JsonMapper 2.9.0_

The examples below map onto the following class:

```php
class User
{
    public string $name;
}
```

## Using a php named function as callback
```php
$middleware = new \JsonMapper\Middleware\ValueTransformation('strtolower');
$mapper = (new \JsonMapper\JsonMapperFactory())->bestFit();
$mapper->unshift($middleware);
$object = new User();

$mapper->mapObjectFromString('{ "name": "JOHN DOE" }', $object);

echo $object->name; // "john doe"
```

## Using a custom callback

Pass `true` as the second constructor argument to have the property name handed to the
callback alongside the value.

```php
$middleware = new \JsonMapper\Middleware\ValueTransformation(
    static function ($key, $value) {
        if ($key === 'name') {
            return \base64_decode($value);
        }

        return $value;
    },
    true
);
$mapper = (new \JsonMapper\JsonMapperFactory())->bestFit();
$mapper->unshift($middleware);
$object = new User();

$mapper->mapObjectFromString('{ "name": "Sm9obiBEb2U=" }', $object);

echo $object->name; // "John Doe"
```
