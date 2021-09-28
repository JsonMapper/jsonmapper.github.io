---
permalink: /docs/advanced/interfaces
title: Interfaces  
---

JsonMapper can support interface types but requires a factory to be registered which can map the data to 
the concrete type of the interface. During the building phase of the JsonMapper
instance you can use the`\JsonMapper\Handler\FactoryRegistry` which is the first parameter
(`$classFactoryRegistry`) to the `\JsonMapper\Handler\PropertyMapper` constructor.

## Example
 ```php
 <?php
 
 $classFactoryRegistry = \JsonMapper\Handler\FactoryRegistry::WithNativePhpClassesAdded();
 $classFactoryRegistry->addFactory(
     \Carbon\CarbonInterface::class,
     function ($date) { return new \Carbon\Carbon($date); }
 );
             
 $mapper = \JsonMapper\JsonMapperBuilder::new()
    ->withPropertyMapper(new \JsonMapper\Handler\PropertyMapper($classFactoryRegistry))
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->withNamespaceResolverMiddleware();
 ``` 