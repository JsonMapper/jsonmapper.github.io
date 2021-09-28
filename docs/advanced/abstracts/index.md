---
permalink: /docs/advanced/abstracts
title: Interfaces  
---

JsonMapper can support abstract types but requires a factory to be registered which can map the data to 
the correct concrete implementation of the abstract class. During the building phase of the JsonMapper 
instance you can use the`\JsonMapper\Handler\FactoryRegistry` which is the second parameter 
(`$nonInstantiableTypeResolver`) to the `\JsonMapper\Handler\PropertyMapper` constructor.

## Example
 ```php
<?php
$nonInstantiableTypeResolver = new \JsonMapper\Handler\FactoryRegistry();
$nonInstantiableTypeResolver->addFactory(
    AbstractShape::class,
    new \JsonMapper\Tests\Implementation\Models\ShapeInstanceFactory()
);

$mapper = \JsonMapper\JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withNamespaceResolverMiddleware()
    ->withPropertyMapper(new \JsonMapper\Handler\PropertyMapper(null, $nonInstantiableTypeResolver))
    ->build();

$object = \JsonMapper\Tests\Implementation\Models\Wrappers\AbstractShapeWrapper();
$mapper->mapObjectFromString('{"shape": {"type": "square", "width": 5, "length": 6}}', $object);
 ``` 
_The classes referenced in the above example can be found as a working example in the [integration test](https://github.com/JsonMapper/JsonMapper/blob/develop/tests/Integration/FeatureSupportsMappingToInterfaceAndAbstractClassTest.php#L27-L42)_