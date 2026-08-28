---
title: Debugging
---

# Debugging

The debugging middleware allows you to log the current state of the ongoing map method. 
The state of the json and object inputs as well as the property map will be logged to an [PSR-3 compliant](https://www.php-fig.org/psr/psr-3/){:target="_blank"} logger

_Available since JsonMapper 1.0.0_

```php
class User
{
    /** @var string */
    public $name;
}

$mapper = (new \JsonMapper\JsonMapperFactory())->default();

# Add the debug middleware with any PSR-3 compliant logger
$logger = new \Monolog\Logger('json-mapper');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));
$mapper->push(new \JsonMapper\Middleware\Debugger($logger));

$object = new User();
$mapper->mapObjectFromString('{ "name": "John Doe" }', $object);
```

Every mapped object produces one debug record holding the JSON, the object being mapped and the
property map as it stood when the middleware ran.
