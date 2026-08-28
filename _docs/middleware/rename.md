---
title: Rename
---

# Rename

The rename middleware uses an explicit defined mapping to rename JSON properties in order
to match your model's naming convention. This way your code doesn't need to follow the same 
naming convention as the JSON API exposes.

_Available since JsonMapper 2.2.0_

```php
class User
{
    public int $id;
    public string $name;
}

$rename = new \JsonMapper\Middleware\Rename\Rename();
$rename->addMapping(User::class, 'Full-Name', 'name');
$rename->addMapping(User::class, 'Identifier', 'id');

# Or you can pass the mappings straight to the constructor
$rename = new \JsonMapper\Middleware\Rename\Rename(
    new \JsonMapper\Middleware\Rename\Mapping(User::class, 'Full-Name', 'name'),
    new \JsonMapper\Middleware\Rename\Mapping(User::class, 'Identifier', 'id')
);

$mapper = (new \JsonMapper\JsonMapperFactory())->bestFit();
$mapper->unshift($rename);
$object = new User();

$mapper->mapObjectFromString('{ "Full-Name": "John Doe", "Identifier": 42 }', $object);

echo $object->id; // 42
echo $object->name; // "John Doe"
```
