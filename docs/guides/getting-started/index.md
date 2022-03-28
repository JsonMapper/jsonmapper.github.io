---
permalink: /docs/guides/getting-started
title: Getting started
---

This guide will explain how to get started with JsonMapper. With JsonMapper the goal is to map a JSON response to a PHP object. 
In this guide we will be using the Chuck Norris facts API. For more details on the API see [https://api.chucknorris.io](https://api.chucknorris.io)

In order to get the JSON data we need to call [https://api.chucknorris.io/jokes/random](https://api.chucknorris.io/jokes/random) which will return the following
structure:
```json
{
    "icon_url" : "https://assets.chucknorris.host/img/avatar/chuck-norris.png",
    "id" : "78KxFWiuT3Wz2TU9n6mZHw",
    "url" : "",
    "value" : "will weston has no balls hes a fucking hermaphrodite. Chuck Norris hates hermaphrodites"
}
```

From that structure a PHP object can be derived
```php
<?php

class ChuckNorrisFact {
    public string $icon_url;
    public string $id;
    public string $url;
    public string $value;
}
``` 

Mapping the JSON to the PHP object is now very simple with the use of JsonMapper
```php
<?php

// Fetch the data from the api endpoint and turn it into an stdClass
$data = file_get_contents('https://api.chucknorris.io/jokes/random');
$json = json_decode($data, false, 512, JSON_THROW_ON_ERROR);

// Create a mapper an Chuck Norris fact
$mapper = (new \JsonMapper\JsonMapperFactory())->bestFit();
$chuckNorrisFact = new ChuckNorrisFact();

// Map the data using JsonMapper
$mapper->mapObject($json, $chuckNorrisFact);

// Or alternatively leave the json decoding to JsonMapper:
$mapper->mapObjectFromString($data, $chuckNorrisFact);
```
