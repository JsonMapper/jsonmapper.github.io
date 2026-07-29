---
permalink: /docs/guides/symfony-usage/
title: Symfony usage  
---

In order to use JsonMapper with your [Symfony](https://symfony.com) application you only need 
JsonMapper's [SymfonyBundle](https://github.com/JsonMapper/SymfonyBundle). 

## Installation
The installation of JsonMapper Symfony package can easily be done with [Composer](https://getcomposer.org)
```bash
$ composer require json-mapper/symfony-bundle
```
<sub>The example shown above assumes that `composer` is on your `$PATH`.</sub>

## Configuration
If your application does not use [Symfony Flex](https://symfony.com/doc/current/setup/flex.html), you need to manually enable the bundle in your `config/bundles.php` file:
```php
<?php

return [
    // ...
    JsonMapper\SymfonyBundle\JsonMapperBundle::class => ['all' => true],
];
```

## Example
Now JsonMapper will be automatically injected if it is provided as one of the constructor arguments.

```php
<?php

namespace App\Service;

use JsonMapper\JsonMapper;

class ApiClient
{
    /** @var JsonMapper */
    private $mapper;
    
    public function __construct(JsonMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
``` 
