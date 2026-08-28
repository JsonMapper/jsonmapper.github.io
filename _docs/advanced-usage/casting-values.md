---
title: Casting values
---

# Casting values

JsonMapper out of the box will come with a `ScalarCaster` configured to cast values to the following types:
 `boolean`, `integer`, `string`, `float` and `mixed`. These casts are applied in order to match the 
properties of the class you're trying to map to.

Alternatively you can configure your mapper with the `StrictScalarCaster`. This caster will throw an
exception when the type of the JSON value doesn't match the type of the property you're trying to map to.

_The `StrictScalarCaster` and the `PropertyMapperBuilder` used below are available since JsonMapper 2.10.0_

```php
<?php

use JsonMapper\Builders\PropertyMapperBuilder;
use JsonMapper\Helpers\StrictScalarCaster;
use JsonMapper\JsonMapperBuilder;

$propertyMapper = PropertyMapperBuilder::new()
    ->withScalarCaster(new StrictScalarCaster())
    ->build();

$mapper = JsonMapperBuilder::new()
    ->withPropertyMapper($propertyMapper)
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->build();
```
