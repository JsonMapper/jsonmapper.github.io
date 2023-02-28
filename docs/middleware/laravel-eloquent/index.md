---
permalink: /docs/middleware/laravel-eloquent/  
title: Laravel Eloquent  
---

The Laravel Eloquent middleware allows you to map JSON data into a Laravel Eloquent model. The middleware uses the power of the
Eloquent features such as automatic database column support, dates and casts.

Saving the data returned from an url as Eloquent models can be achieved with the following code:
```php
<?php

$url = 'https://api.opensource.org/licenses/';
$data = file_get_contents($url);

$mapper = (new JsonMapperFactory())->create();
$mapper->push(new EloquentMiddleware(new ArrayCache()));

$licenses = $mapper->mapArrayFromString($data, new License());
Collection::make($licenses)->each(fn(License $l) => $l->save());
```

_This middleware is part of separate repository and need to be installed using `composer require json-mapper/eloquent-middleware`_ 