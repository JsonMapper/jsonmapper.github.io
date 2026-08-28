---
title: Debugging
---

# Debugging

The debugging middleware allows you to log the current state of the ongoing map method. 
The state of the json and object inputs as well as the property map will be logged to an [PSR-3 compliant](https://www.php-fig.org/psr/psr-3/){:target="_blank"} logger

_Available since JsonMapper 1.0.0_

```php
<?php

use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\Debugger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class User
{
    /** @var string */
    public $name;
}

$mapper = (new JsonMapperFactory())->default();

# Add the debug middleware with any PSR-3 compliant logger
$logger = new Logger('json-mapper');
$logger->pushHandler(new StreamHandler('php://stdout'));
$mapper->push(new Debugger($logger));

$object = new User();
$mapper->mapObjectFromString('{ "name": "John Doe" }', $object);
```

Every mapped object produces one debug record holding the JSON, the object being mapped and the
property map as it stood when the middleware ran.
