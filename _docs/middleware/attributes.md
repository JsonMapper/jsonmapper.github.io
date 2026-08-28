---
title: PHP 8.0 Attributes
---

# PHP 8.0 Attributes

The attributes middleware uses the PHP 8.0 attributes to map JSON data from names that do not match the model.
 This way your code doesn't need to follow the same naming convention as the JSON API exposes.

```php
class User
{
    #[\JsonMapper\Middleware\Attributes\MapFrom("Identifier")]
    public int $id;
    #[\JsonMapper\Middleware\Attributes\MapFrom("UserName")]
    public string $name;
}

$cache = new \JsonMapper\Cache\NullCache();
$mapper = (new \JsonMapper\JsonMapperFactory())->create(
    new \JsonMapper\Handler\PropertyMapper(),
    new \JsonMapper\Middleware\Attributes\Attributes(),
    new \JsonMapper\Middleware\TypedProperties($cache)
);
$object = new User();

$mapper->mapObjectFromString('{ "UserName": "John Doe", "Identifier": 42 }', $object);

echo $object->id; // 42
echo $object->name; // "John Doe"
```
