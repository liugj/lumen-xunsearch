Lumen XunSearch
==============

Xunsearch Engine for Laravel Scout.

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

### Where Clauses

This enginge allows you to add more advanced "where" clauses.

* addRange 

```
   $users = App\User::search('Star Trek')
            ->where('age', new \Liugj\Xunsearch\Operators\RangeOperator(30,50))->get();
```

* setCollapse

```
   $users = App\User::search('Star Trek')
            ->where('city', new \Liugj\Xunsearch\Operators\CollapseOperator($num = 10))->get();
```

* setFuzzy

```
   $users = App\Users::search('Star Trek')
           ->where('**', new \Liugj\Xunsearch\Operators\FuzzyOperator($fuzzy = false))->get();
```

* addWeight

```
   $users = App\User::search('Star Trek')
   ->where('country', new \Liugj\Xunsearch\Operators\WeightOperator('US'))->get();
```

### Configuring Searchable Data

By default, the entire toArray form of a given model will be persisted to its search index. If you would like to customize the data that is synchronized to the search index, you may override the  toSearchableArray method on the model:


```
<?php

namespace App;

use Liugj\Xunsearch\Searchable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}

```


##Links

- [Xunsearch](http://www.xunsearch.com/)


## Credits

- [liugj](https://github.com/liugj)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
