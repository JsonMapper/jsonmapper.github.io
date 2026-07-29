---
permalink: /docs/middleware/constructor/  
title: Constructor 
---

The constructor middleware (introduced in JsonMapper version 2.14.0) uses reflection to register a custom factory to the factory registry
which can utilise the class constructor. This enables the use of custom constructors without having to manually write factories. This feature
can be combined with the readonly properties introduced with PHP 8.1.
 
```php
class User
{
    public function __construct(
        public readonly $name,
    ) {}
}

$cache = new NullCache();
$factoryRegistry = new FactoryRegistry();
$mapper = JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withObjectConstructorMiddleware($factoryRegistry)
    ->withPropertyMapper(new PropertyMapper($factoryRegistry))
    ->build();

$mapper->mapToClassFromString('{ "name": "John Doe" }', User::class);

echo $object->name; // "John Doe"
```
