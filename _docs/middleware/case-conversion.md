---
title: Case conversion
---

# Case conversion

The case conversion middleware can map from a specific text notation to another text notation.
 This way your code doesn't need to follow the same text notation as the JSON API exposes.

_Available since JsonMapper 0.3.0_

```php
<?php

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;

class User
{
    /** @var string */
    public $name;
}

$mapper = (new JsonMapperFactory())->default();

# Add the middleware to convert from studly caps to camel case
$mapper->push(new CaseConversion(
    TextNotation::STUDLY_CAPS(),
    TextNotation::CAMEL_CASE()
));

$object = new User();
$mapper->mapObjectFromString('{ "Name": "John Doe" }', $object);

echo $object->name; // "John Doe"
```

The case conversion middleware currently supports the following text notations:
* **Studly caps**
* **Camel case**
* **Underscore**
* **Kebab case**
