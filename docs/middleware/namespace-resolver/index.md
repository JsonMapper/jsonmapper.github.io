---
permalink: /docs/middleware/namespace-resolver/  
title: Namespace resolver  
---

The namespace resolver middleware will tokenize the target object using [nikic/php-parser](https://github.com/nikic/PHP-Parser){:target="_blank"}
in order to get the namespaces that are imported.  These imports will be applied to the object properties found in the property map. 

_This middleware is part of both the default and best fit factory methods as it provides elementary functionality to JsonMapper_ 

## Example
```php
<?php

use App\Api\Joke\Response;

# The namespace resolver middleware is included in the default and best fit of JsonMapper.
$mapper = (new \JsonMapper\JsonMapperFactory())->default();

$object = new Response();
$jsonString = file_get_contents('https://api.chucknorris.io/jokes/search?query=programming');

$mapper->mapObject($jsonString, $object);

echo $object->result[0]->value; // "Chuck Norris insists on strongly-typed programming languages."
```

```php
<?php

#./App/Api/Joke/Response
namespace App\Api\Joke;

use App\Dto\Joke;

class Response
{
    /** @var int */
    public $total;
    /** @var Joke[] */
    public $result;
}
```

```php
<?php

#./App/Dto/Joke
namespace App\Dto;

class Joke
{
    /** @var int */
    public $value;
}
```