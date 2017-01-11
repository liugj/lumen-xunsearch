Lumen XunSearch
==============

[![Latest Stable Version](https://poser.pugx.org/liugj/lumen-xunsearch/version)](https://packagist.org/packages/liugj/lumen-xunsearch)
[![Latest Unstable Version](https://poser.pugx.org/liugj/lumen-xunsearch/v/unstable.png)](https://packagist.org/packages/liugj/lumen-xunsearch)
[![License](https://poser.pugx.org/liugj/lumen-xunsearch/license)](https://packagist.org/packages/liugj/lumen-xunsearch)
[![Total Downloads](https://poser.pugx.org/liugj/lumen-xunsearch/downloads)](https://packagist.org/packages/liugj/lumen-xunsearch)
[![composer.lock available](https://poser.pugx.org/liugj/lumen-xunsearch/composerlock)](https://packagist.org/packages/liugj/lumen-xunsearch)

Xunsearch Driver for Laravel Scout.

## Installation

You can install the package via composer:

```bash
composer require liugj/lumen-xunsearch
```

You must add the Scout service provider and the package service provider in your `bootstrap/app.php` line 80 config:

```php
$app->register(Liugj\Xunsearch\XunsearchServiceProvider::class);
```

## Configuration 

Publish the config file into your project by edit `config/scout.php` line 62:

```bash
    'xunsearch' => [
        'index'  => env('XUNSEARCH_INDEX_HOST', ''),
        'search' => env('XUNSEARCH_SEARCH_HOST', ''),
        'schema' => [
           'brand_index'=>app()->basePath()  .'/'. env('XUNSEARCH_SCHEMA_BRAND'),
        ]
    ],
```

Add Xunsearch settings into `.env` file:

```
SCOUT_DRIVER=xunsearch
XUNSEARCH_INDEX_HOST=172.16.76.233:8383
XUNSEARCH_SEARCH_HOST=172.16.76.233:8384
```

## Usage

Now you can use Laravel Scout as described in the [official documentation](https://laravel.com/docs/5.3/scout).

##Links

- [Xunsearch](http://www.xunsearch.com/)


## Credits

- [liugj](https://github.com/liugj)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
