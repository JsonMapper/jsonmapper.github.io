```php
$mapper = JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->build();

$object = $mapper->mapToClass('{ "name": "John Doe" }', \Tests\JsonMapper\Implementation\SimpleObject::class);

echo $object->getName(); // "John Doe"
```
