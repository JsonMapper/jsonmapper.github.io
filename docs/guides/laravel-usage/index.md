---
permalink: /docs/guides/laravel-usage/
title: Laravel usage  
---

In order to use JsonMapper with your [Laravel](https://laravel.com){:target="_blank"} application you only need 
JsonMapper's [LaravelPackage](https://github.com/JsonMapper/LaravelPackage){:target="_blank"}. 

## Installation
The installation of JsonMapper Laravel package can easily be done with [Composer](https://getcomposer.org){:target="_blank"}
```bash
$ composer require json-mapper/laravel-package
```
This package makes use of [Laravels package auto-discovery mechanism](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518){:target="_blank"}.

<sub> * The example shown above assumes that `composer` is on your `$PATH`. </sub>

## Configuration
Copy the package config to your local config with the publish command:
```bash
php artisan vendor:publish --provider="JsonMapper\LaravelPackage\ServiceProvider"
```
The package config enables you to choose between the `default` JsonMapper or the `best-fit` JsonMapper. 
You can check the [Setup]({% link docs/usage/setup/index.md %}) page for more info of the different types.

## Example
```php
<?php

namespace App\Service;

use JsonMapper\LaravelPackage\JsonMapperInterface;

class ApiClient
{
    private JsonMapperInterface $mapper;
    
    public function __construct(private JsonMapperInterface $mapper) {}
    
    public function fetchJokes(): Collection
    {
        $data = file_get_contents('https://official-joke-api.appspot.com/jokes/ten');
        
        return $this->mapper->mapToCollectionFromString($data, new Joke());
    }
}

class Joke
{
    public int $id;
    public string $type;
    public string $setup;
    public string $punchline;
}
```