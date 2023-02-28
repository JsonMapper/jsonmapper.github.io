---
permalink: /docs/middleware/typed-properties/  
title: Typed properties  
---

The typed properties middleware will scan the target object using [Reflection](https://www.php.net/manual/en/intro.reflection.php){:target="_blank"}
for properties.  
Using the reflection information it will determine the property type and amend these results to the property map.
The property map is utilised by the PropertyMapper when applying the data from the JSON object to the target object. 

_This middleware requires PHP 7.4 and is part of the best fit factory method as it provides elementary functionality to JsonMapper_ 

## Example
```php
<?php

# The TypedProperties middleware is included in the best fit of JsonMapper and requires PHP 7.4 or higher.
$mapper = (new \JsonMapper\JsonMapperFactory())->bestFit();

$object = new Joke();
$jsonString = file_get_contents('https://official-joke-api.appspot.com/jokes/random');

$mapper->mapObjectFromString($jsonString, $object);

echo $object->setup; // "What do you call a pile of cats?"
echo $object->punchline; // "A Meowtain."

class Joke
{
    public int $id;
    public string $type;
    public string $setup;
    public string $punchline;
}
```