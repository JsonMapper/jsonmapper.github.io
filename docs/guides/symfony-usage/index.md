---
permalink: /docs/guides/symfony-usage/
title: Symfony usage  
---

In order to use JsonMapper with your [Symfony](https://symfony.com){:target="_blank"} application you only need 
JsonMapper's [SymfonyBundle](https://github.com/JsonMapper/SymfonyBundle){:target="_blank"}. 

The installation of JsonMapper Symfony package can easily be done with [Composer](https://getcomposer.org){:target="_blank"}
```bash
$ composer require json-mapper/symfony-bundle
```
The example shown above assumes that `composer` is on your `$PATH`.

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
