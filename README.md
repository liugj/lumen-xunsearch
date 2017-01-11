Lumen XunSearch
==============

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
XUNSEARCH_INDEX_HOST=127.0.0.1:8383
XUNSEARCH_SEARCH_HOST=127.0.0.1:8384
XUNSEARCH_SCHEMA_BRAND=config/brand.ini
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
