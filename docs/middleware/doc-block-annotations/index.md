---
permalink: /docs/middleware/doc-block-annotations/  
title: DocBlock annotations  
---

The DocBlock annotations middleware will scan the target object using [Reflection](https://www.php.net/manual/en/intro.reflection.php){:target="_blank"}
for properties and their [DocBlock](https://docs.phpdoc.org/guide/references/phpdoc/index.html){:target="_blank"}  annotations. 
Using the annotations it will determine the property type and amend these results to the property map.
The property map is utilised by the PropertyMapper when applying the data from the JSON object to the target object. 

_This middleware is part of both the default and best fit factory methods as it provides elementary functionality to JsonMapper_

## Example
```php
<?php

# The Doc Block middleware is included in the default and best fit of JsonMapper.
$mapper = (new \JsonMapper\JsonMapperFactory())->default();

$object = new Joke();
$jsonString = file_get_contents('https://official-joke-api.appspot.com/jokes/random');

$mapper->mapObjectFromString($jsonString, $object);

echo $object->setup; // "What do you call a pile of cats?"
echo $object->punchline; // "A Meowtain."

class Joke
{
    /** @var int */
    public $id;
    /** @var string */
    public $type;
    /** @var string */
    public $setup;
    /** @var string */
    public $punchline;
}
```
