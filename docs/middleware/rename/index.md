---
permalink: /docs/middleware/rename/  
title: Rename
---

The rename middleware uses an explicit defined mapping to rename JSON properties in order
to match your model's naming convention. This way your code doesn't need to follow the same 
naming convention as the JSON API exposes.
 
```php
$rename = new Rename();
$rename->addMapping(User::class, 'Full-Name', 'name');
$rename->addMapping(User::class, 'Identifier', 'id');
$mapper = (new JsonMapperFactory())->bestFit();
$mapper->unshift($rename);
$object = new User();

$mapper->mapObject(json_decode('{ "Full-Name": "John Doe", "Identifier": 42 }'), $object);

echo $object->getId(); // 42
echo $object->getName(); // "John Doe"
```