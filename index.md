---
permalink: /  
title: Introduction  
---

JsonMapper is a powerful open-source package that enables users to map JSON data to PHP classes with ease. It offers a 
series of middleware that can be arranged and sorted to meet your specific needs, making it a flexible solution for a 
wide range of use cases.

One of the great things about JsonMapper is how easy it is to use. With just a few lines of code, you can map JSON data 
to a PHP class and start working with it right away. For example, the following code maps a JSON string to a 
SimpleObject class and returns the name property:
```php
$mapper = JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->build();

$object = $mapper->mapToClass('{ "name": "John Doe" }', \Tests\JsonMapper\Implementation\SimpleObject::class);

echo $object->getName(); // "John Doe"
```

## Why use JsonMapper
One of the most important features of JsonMapper is its support for typed properties, which makes it easy to map JSON
data to PHP classes with strong type checking. Additionally, it offers support for custom constructors and readonly
properties/classes, which gives you greater control over how your data is mapped.

Another key feature of JsonMapper is its capability to resolve namespace uses, which helps ensure that the implementation
in your code can be as you desire in order to keep it well-organized and easy to maintain. It also supports mapping
properties using PHP attributes, value transformation using a callback, resolving types from more traditional DocBlock
annotations, case conversion, and debugging, making it a robust solution for even the most complex mapping tasks.

One of the great things about JsonMapper is that it is highly extensible. If the out-of-the-box middleware don't meet 
your specific needs, it's very easy to create your own custom middleware to handle your specific use case.
