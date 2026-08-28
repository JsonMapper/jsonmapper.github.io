---
title: Interfaces
---

# Interfaces

JsonMapper can support interface types but requires a factory to be registered which can map the data to 
the concrete type of the interface. During the building phase of the JsonMapper
instance you can use the`\JsonMapper\Handler\FactoryRegistry` which is the first parameter
(`$classFactoryRegistry`) to the `\JsonMapper\Handler\PropertyMapper` constructor.

## Example
```php
<?php

use Carbon\Carbon;
use Carbon\CarbonInterface;
use JsonMapper\Handler\FactoryRegistry;
use JsonMapper\Handler\PropertyMapper;
use JsonMapper\JsonMapperBuilder;

$classFactoryRegistry = FactoryRegistry::withNativePhpClassesAdded();
$classFactoryRegistry->addFactory(
    CarbonInterface::class,
    function ($date) { return new Carbon($date); }
);

$mapper = JsonMapperBuilder::new()
    ->withPropertyMapper(new PropertyMapper($classFactoryRegistry))
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->withNamespaceResolverMiddleware()
    ->build();
```
