```php
use JsonMapper\JsonMapperBuilder;

class User
{
    public string $name;
}

$mapper = JsonMapperBuilder::new()
    ->withDocBlockAnnotationsMiddleware()
    ->withTypedPropertiesMiddleware()
    ->build();

$user = $mapper->mapToClassFromString('{ "name": "John Doe" }', User::class);

echo $user->name; // "John Doe"
```
