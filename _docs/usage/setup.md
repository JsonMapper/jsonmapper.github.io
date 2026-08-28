---
title: Setup
---

# Setup

## Quick and easy setup
Setting up JsonMapper for your project is simple. JsonMapper comes with a factory that
offers three methods to create a JsonMapper instance.

```php
<?php

use JsonMapper\JsonMapperFactory;

// Use `default` which offers the most lightweight JsonMapper. It includes the
// DocBlock annotations and namespace resolver middleware.
$default = (new JsonMapperFactory())->default();

// Use `bestFit` to get the JsonMapper that fits best to your PHP runtime
// version. Since PHP 7.4 is the minimum supported version, this always adds
// the typed properties middleware on top of the default set.
$bestFit = (new JsonMapperFactory())->bestFit();
```

Use `create` to build an instance with your own property mapper and your own series of
middleware. Unlike `default` and `bestFit` it adds no middleware of its own, so pass at
least one — building a mapper with an empty middleware chain throws a `BuilderException`.

```php
<?php

use JsonMapper\Cache\ArrayCache;
use JsonMapper\Handler\PropertyMapper;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\DocBlockAnnotations;
use JsonMapper\Middleware\NamespaceResolver;

$cache = new ArrayCache();

$custom = (new JsonMapperFactory())->create(
    new PropertyMapper(),
    new DocBlockAnnotations($cache),
    new NamespaceResolver($cache)
);
```

## Tailored setup
Since version 2.3.0 JsonMapper offers a `JsonMapperBuilder` class which can be used to have a more tailored
setup of your mapper instance. In version 2.10.0 the `PropertyMapperBuilder` was introduced. Below you can find
an example that shows how you can create a JsonMapper instance using the builders.

```php
<?php

use JsonMapper\Builders\PropertyMapperBuilder;
use JsonMapper\Cache\ArrayCache;
use JsonMapper\Helpers\StrictScalarCaster;
use JsonMapper\JsonMapperBuilder;

$propertyMapper = PropertyMapperBuilder::new()
    ->withScalarCaster(new StrictScalarCaster())
    ->build();

$mapper = JsonMapperBuilder::new()
    ->withJsonMapperClassName(YourExtendedJsonMapper::class)
    ->withPropertyMapper($propertyMapper)
    ->withDefaultCache(new ArrayCache())
    ->withDocBlockAnnotationsMiddleware()
    ->build();
```

Both builders are created through a static `new()` method. The class passed to
`withJsonMapperClassName()` must implement `\JsonMapper\JsonMapperInterface`; the cache given
to `withDefaultCache()` is handed to every middleware that is added without a cache of its own.
