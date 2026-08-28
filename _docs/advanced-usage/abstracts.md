---
title: Abstract classes
---

# Abstract classes

JsonMapper can support abstract types but requires a factory to be registered which can map the data to 
the correct concrete implementation of the abstract class. During the building phase of the JsonMapper 
instance you can use the`\JsonMapper\Handler\FactoryRegistry` which is the second parameter 
(`$nonInstantiableTypeResolver`) to the `\JsonMapper\Handler\PropertyMapper` constructor.

## Example
```php
<?php

$nonInstantiableTypeResolver = new \JsonMapper\Handler\FactoryRegistry();
$nonInstantiableTypeResolver->addFactory(
    \App\Shapes\AbstractShape::class,
    new \App\Shapes\ShapeInstanceFactory()
);

$mapper = \JsonMapper\JsonMapperBuilder::new()
    ->withPropertyMapper(new \JsonMapper\Handler\PropertyMapper(null, $nonInstantiableTypeResolver))
    ->withDocBlockAnnotationsMiddleware()
    ->withNamespaceResolverMiddleware()
    ->build();

$object = new \App\Shapes\AbstractShapeWrapper();
$mapper->mapObjectFromString('{"shape": {"type": "square", "width": 5, "length": 6}}', $object);
```

_`AbstractShape`, `AbstractShapeWrapper` and `ShapeInstanceFactory` above stand in for your own classes. A
working equivalent can be found in the [integration test](https://github.com/JsonMapper/JsonMapper/blob/develop/tests/Integration/FeatureSupportsMappingToInterfaceAndAbstractClassTest.php#L27-L42)._
