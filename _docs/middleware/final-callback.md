---
title: Final callback
---

# Final callback

Using the final callback middleware it is possible to invoke a callback because you might need to initialise some method on your model or perhaps want to put it into cache.

_Available since JsonMapper 0.3.0_

```php
<?php

use JsonMapper\JsonMapperFactory;
use JsonMapper\JsonMapperInterface;
use JsonMapper\Middleware\FinalCallback;
use JsonMapper\ValueObjects\PropertyMap;
use JsonMapper\Wrapper\ObjectWrapper;

class User
{
    /** @var string */
    public $name;

    public function done(): void
    {
        // Whatever your model needs once it has been filled.
    }
}

$mapper = (new JsonMapperFactory())->default();

# Add the callback middleware
$mapper->push(new FinalCallback(function (
    \stdClass $json,
    ObjectWrapper $object,
    PropertyMap $map,
    JsonMapperInterface $mapper
) {
    // Call a method on the object
    $object->getObject()->done();
    // Or persist it in the cache
    Cache::put('key', $object->getObject(), $seconds);
}));

$object = new User();
$mapper->mapObjectFromString('{ "name": "John Doe" }', $object);
```

The callback is applied to the top level object only. Pass `false` as the second constructor
argument to have it invoked for nested objects as well.
