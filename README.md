# JsonMapper.net

This repository contains the source code for the [JsonMapper.net](https://jsonmapper.net) website.
For the JsonMapper package, see the [JsonMapper/JsonMapper](https://github.com/JsonMapper/JsonMapper) repository.

## Local Development

Requirements:

- [PHP 8.2+](https://www.php.net/)
- [Composer](https://getcomposer.org/)

This site now uses [HydePHP 2](https://hydephp.com/) as its static site generator.

To run the site locally:

```shell
# Install PHP dependencies
composer install

# Start the Hyde development server
php hyde serve
```

To create a production build:

```shell
php hyde build
```
