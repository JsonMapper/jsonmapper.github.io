```php
class User
{
    public string $name;
}

$mapper = \JsonMapper\JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->build();

$user = $mapper->mapToClassFromString('{ "name": "John Doe" }', User::class);

echo $user->name; // "John Doe"
```
