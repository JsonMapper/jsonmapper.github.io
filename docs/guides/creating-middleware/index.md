---
permalink: /docs/guides/creating-middleware
title: Creating middleware
---

One of the great things about JsonMapper is that it is highly extensible. If the out-of-the-box middleware don't meet 
your specific needs, it's very easy to create your own custom middleware to handle your specific use case.

To create your own middleware, you need to define a class that implements the JsonMapper\Middleware\MiddlewareInterface 
interface. This interface requires the implementation of a single method called process, which takes the input JSON data 
and the target PHP object as arguments, and returns the transformed PHP object.

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

Once you've created your custom middleware, you can add it to the middleware stack using the addMiddleware method of 
the JsonMapper or JsonMapperFactory classes, like this:

```php
$mapper = JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->withMiddleware(new CustomMiddleware())
    ->build();
```
