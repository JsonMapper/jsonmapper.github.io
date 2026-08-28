---
title: Debugging
---

# Debugging

The debugging middleware allows you to log the current state of the ongoing map method. 
The state of the json and object inputs as well as the property map will be logged to an [PSR-3 compliant](https://www.php-fig.org/psr/psr-3/){:target="_blank"} logger

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

## What gets logged

Each object that passes through the middleware produces one record at `debug` level, with the message
`Current state attributes passed through JsonMapper middleware` and three context entries:

| Key | Contents |
|---|---|
| `json` | The JSON for the object currently being mapped, re-encoded as a string |
| `object` | The name of the class being mapped onto |
| `propertyMap` | The property map as it stood when the middleware ran, as a JSON string |

The example above logs:

```text
[debug] Current state attributes passed through JsonMapper middleware
    json: {"name":"John Doe"}
    object: User
    propertyMap: {"properties":{"name":{"name":"name","types":[{"type":"string","isArray":false,"arrayInformation":{"isArray":false,"dimensions":0}}],"visibility":"public","isNullable":false}}}
```

The property map is the interesting part, and it is easier to read reformatted. It records the type
each middleware resolved for every property, which is what to check when a property is silently left
unset:

```json
{
  "properties": {
    "name": {
      "name": "name",
      "types": [
        {
          "type": "string",
          "isArray": false,
          "arrayInformation": { "isArray": false, "dimensions": 0 }
        }
      ],
      "visibility": "public",
      "isNullable": false
    }
  }
}
```

## Where you place the middleware matters

The property map is built up by the middleware ahead of the debugger in the chain, so the position you
add it in decides what you see.

`push()` puts it last, after the middleware that populate the map have run, which is what you usually
want — the map is fully resolved, as above.

`unshift()` puts it first, before anything has contributed, and the map is still empty:

```text
[debug] Current state attributes passed through JsonMapper middleware
    json: {"name":"John Doe"}
    object: User
    propertyMap: {"properties":[]}
```

That is the view to use when you want the raw JSON as it arrived, before any renaming or case
conversion middleware has altered it.

## Nested objects

The middleware runs once per object, not once per mapping call, so a nested structure produces a
record for each object. Mapping `{ "name": "John Doe", "address": { "city": "Amsterdam" } }` onto a
`Person` holding an `Address` logs the outer object first and then the inner one (the `propertyMap`
entry is elided here):

```text
[debug] Current state attributes passed through JsonMapper middleware
    json: {"name":"John Doe","address":{"city":"Amsterdam"}}
    object: Person
    propertyMap: ...

[debug] Current state attributes passed through JsonMapper middleware
    json: {"city":"Amsterdam"}
    object: Address
    propertyMap: ...
```
