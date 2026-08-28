---
title: Architecture
navigation:
    group: General
---

# Architecture

## Middleware
The core of JsonMapper is build using the chain of responsibility pattern allowing multiple
middleware being added to the mapper. This pattern allows for easy customisation for each
individual project.
This also allows for custom middleware to meet edge cases not offered in the middleware that is par of JsonMapper.

```php
<?php

use JsonMapper\Cache\ArrayCache;
use JsonMapper\Handler\PropertyMapper;
use JsonMapper\JsonMapper;
use JsonMapper\JsonMapperInterface;
use JsonMapper\Middleware\AbstractMiddleware;
use JsonMapper\Middleware\DocBlockAnnotations;
use JsonMapper\Middleware\NamespaceResolver;
use JsonMapper\ValueObjects\PropertyMap;
use JsonMapper\Wrapper\ObjectWrapper;

$cache = new ArrayCache();
$mapper = new JsonMapper(new PropertyMapper());

/* Push included middleware onto the mapper */
$mapper->push(new DocBlockAnnotations($cache));
$mapper->push(new NamespaceResolver($cache));

/* Add custom middleware */
$mapper->push(new class extends AbstractMiddleware {
    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $map,
        JsonMapperInterface $mapper
    ): void {
        /* Custom logic here */
    }
});
```

## Supported PHP versions
JsonMapper currently supports PHP versions 7.4 and higher. 