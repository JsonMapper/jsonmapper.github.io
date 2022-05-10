---
permalink: /docs/usage/setup
title: Setup
---

# Quick and easy setup
Setting up JsonMapper for your project is simple. JsonMapper comes with a factory that
offers three methods to create a JsonMapper instance.

```php
<?php

// Simply use `default` which offers the most light weigth JsonMapper
$default = (new \JsonMapper\JsonMapperFactory())->default();

// Use the `bestFit` to get the JsonMapper that fits best 
// to your PHP runtime version.  
$bestfit = (new \JsonMapper\JsonMapperFactory())->bestFit();

// Use `create` to build a new instance with a custom 
// property mapper and series of middleware
$custom = (new \JsonMapper\JsonMapperFactory())->create(
  new PropertyMapper, 
  new \JsonMapper\Middleware\DocBlockAnnotations(),   
  ...
);
```  

# Tailored setup
Since version 2.3.0 JsonMapper offers a `JsonMapperBuilder` class which can be used to have a more tailored
setup of your mapper instance. In version 2.10.0 the `PropertyMapperBuilder` was introduced. Below you can find
an example that shows how to can create a JsonMapper instance using the builder.

```php
<?php

$propertyMapperBuilder = PropertyMapperBuilder::create()
    ->withScalarCaster(new StrictScalarCaster());
$jsonMapperBuilder = JsonMapperBuilder::create()
    ->withJsonMapperClass(YourExtendedJsonMapper::class)
    ->withProperyMapper(new PropertyMapper)
    ->withDefaultCache(new ArrayCache)
    ->withDocBlockAnnotationsMiddleware()
    ->withPropertyMapper($propertyMapperBuilder->build());

$mapper = $jsonMapperBuilder->build();
```