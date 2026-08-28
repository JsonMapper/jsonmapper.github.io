---
title: PHP 8.0 Attributes
---

# PHP 8.0 Attributes

The attributes middleware uses the PHP 8.0 attributes to map JSON data from names that do not match the model.
 This way your code doesn't need to follow the same naming convention as the JSON API exposes.

_Available since JsonMapper 1.4.0_

```php
<?php

use JsonMapper\Cache\NullCache;
use JsonMapper\Handler\PropertyMapper;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\Attributes\Attributes;
use JsonMapper\Middleware\Attributes\MapFrom;
use JsonMapper\Middleware\TypedProperties;

class User
{
    #[MapFrom("Identifier")]
    public int $id;
    #[MapFrom("UserName")]
    public string $name;
}

$cache = new NullCache();
$mapper = (new JsonMapperFactory())->create(
    new PropertyMapper(),
    new Attributes(),
    new TypedProperties($cache)
);
$object = new User();

$mapper->mapObjectFromString('{ "UserName": "John Doe", "Identifier": 42 }', $object);

echo $object->id; // 42
echo $object->name; // "John Doe"
```
