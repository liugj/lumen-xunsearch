Laravel XunSearch
==============

[![Latest Stable Version](https://poser.pugx.org/nicolasliu/laravel-xunsearch/version)](https://packagist.org/packages/nicolasliu/laravel-xunsearch)
[![Latest Unstable Version](https://poser.pugx.org/nicolasliu/laravel-xunsearch/v/unstable.png)](https://packagist.org/packages/nicolasliu/laravel-xunsearch)
[![License](https://poser.pugx.org/nicolasliu/laravel-xunsearch/license)](https://packagist.org/packages/nicolasliu/laravel-xunsearch)
[![Total Downloads](https://poser.pugx.org/nicolasliu/laravel-xunsearch/downloads)](https://packagist.org/packages/nicolasliu/laravel-xunsearch)
[![composer.lock available](https://poser.pugx.org/nicolasliu/laravel-xunsearch/composerlock)](https://packagist.org/packages/nicolasliu/laravel-xunsearch)

Xunsearch Driver for Laravel Scout.

## Installation

You can install the package via composer:

```bash
composer require liugj/lumen-xunsearch
```

You must add the Scout service provider and the package service provider in your `app.php` config:

```php
'providers' => [
	Liugj\Xunsearch\XunsearchServiceProvider::class,
],
```


## Configuration 

Publish the config file into your project by running:

```bash
php artisan vendor:publish --provider="Nicolasliu\Xunsearch\XunsearchServiceProvider"
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

- [NicolasLiu](https://github.com/nicolasliu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
