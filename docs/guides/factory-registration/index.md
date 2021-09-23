---
permalink: /docs/guides/factory-registration
title: Factory registration
---
When using an interface typed property a proper factory must be registered, otherwise JsonMapper will crash.

Basic usage:
```php
<?php
$jsonMapper = (new \JsonMapper\JsonMapperFactory())->bestFit();
$factoryRegistry = JsonMapper\Handler\FactoryRegistry::WithNativePhpClassesAdded();
$factoryRegistry->addFactory(
                CarbonInterface::class,
                fn($date) => new Carbon($date)
            );
$jsonMapper->setPropertyMapper(new JsonMapper\Handler\PropertyMapper($factoryRegistry));
``` 