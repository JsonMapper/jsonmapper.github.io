---
title: Final callback
---

# Final callback

Using the final callback middleware it is possible to invoke a callback because you might need to initialise some method on your model or perhaps want to put it into cache.

```php
class User
{
    /** @var string */
    public $name;

    public function done(): void
    {
        // Whatever your model needs once it has been filled.
    }
}

$mapper = (new \JsonMapper\JsonMapperFactory())->default();

# Add the callback middleware
$mapper->push(new \JsonMapper\Middleware\FinalCallback(function(
    \stdClass $json,
    \JsonMapper\Wrapper\ObjectWrapper $object,
    \JsonMapper\ValueObjects\PropertyMap $map,
    \JsonMapper\JsonMapperInterface $mapper
) {
    // Call a method on the object now that it has been filled
    $object->getObject()->done();
    // ...or hand it to a cache, a queue, an event dispatcher, and so on
}));

$object = new User();
$mapper->mapObjectFromString('{ "name": "John Doe" }', $object);
```

The callback is applied to the top level object only. Pass `false` as the second constructor
argument to have it invoked for nested objects as well.
