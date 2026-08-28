---
title: Creating middleware
---

# Creating middleware

One of the great things about JsonMapper is that it is highly extensible. If the out-of-the-box middleware don't meet 
your specific needs, it's very easy to create your own custom middleware to handle your specific use case.

To create your own middleware, you need to define a class that implements `JsonMapper\Middleware\MiddlewareInterface`.
The easiest way to do so is to extend `JsonMapper\Middleware\AbstractMiddleware`, which leaves you a single method to
implement: `handle()`. It receives the JSON data, the object being mapped, the property map built so far, and the mapper
itself, and amends them in place rather than returning anything.

Here's an example of how to create a simple middleware that converts a JSON string to an array before it's mapped to 
a PHP class:

```php
use JsonMapper\Middleware\AbstractMiddleware;
use JsonMapper\JsonMapperInterface;
use JsonMapper\ValueObjects\PropertyMap;
use JsonMapper\Wrapper\ObjectWrapper;

class CustomMiddleware extends AbstractMiddleware
{
    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void
    {
        // Custom logic goes here.
    }
}
```

Once you've created your custom middleware, you can add it to the middleware stack with the builder's `withMiddleware`
method, like this:

```php
$mapper = \JsonMapper\JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->withMiddleware(new CustomMiddleware())
    ->build();
```
