Mapping library
===========

This library is created to improve mapping data from one form to another.

It was created during struggle with not-so-clean mapping from ( and to ) Elasticsearch and Redis.


Read model mappers
--------------

Read model mapper role is to create specific objects and fill it with given data.


Example:
   
```php
use Deetrych\Mapping\Mapper\ReadModel\Factory;

$factory = new Factory(
    [
        ['model' => FlatProduct::class, 'type' => 'array', 'fields' => ['price' => 'product.value', 'currency' => 'product.currency']],
        ['model' => FlatProduct::class, 'type' => 'json', 'fields' => ['priceValue' => 'product.value']],
    ],
    [
        'array' => ArrayMapper::class,
        'json' => JsonMapper::class
    ]
);
$arrayMapper = $factory->createFromType('array');
$result = $arrayMapper->map(['product' => ['value' => 100, 'currency' => 'GBP']);

var_dump($result);

// $result would be
// object(FlatProduct)#23 (3) {
//     ["price":"FlatProduct":private]=>
//     100
//     ["currency":"FlatProduct":private]=>
//     GBP
//   }

```


Write model mappers
--------------

Write model mapper role is to create specific data structure from given object. You can think about it as a serializer.

Example:
   
```php
use Deetrych\Mapping\Mapper\WriteModel\Factory;

$factory = new Factory(
    [
        ['type' => 'array', 'fields' => ['price' => 'product.price.value', 'currency' => 'product.price.currency']],
        ['type' => 'json', 'fields' => ['priceValue' => 'product.price.value']],
    ],
    [
        'array' => ArrayMapper::class,
        'json' => JsonMapper::class
    ]
);
$arrayMapper = $factory->createFromType('array');
$result = $arrayMapper->map(new Product(new Price(10, 'GBP')));

var_dump($result);

// $result would be
//array(2) {
//     ["price"]=>
//     int(10)
//     ["currency"]=>
//     string(GBP)
//   }

```
