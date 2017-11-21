
[![Build Status](https://travis-ci.org/isholao/callableresolver.svg?branch=master)](https://travis-ci.org/isholao/callableresolver)

Install
-------

To install with composer:

```sh
composer require isholao/callableresolver
```

Requires PHP 7.1 or newer.

Usage
-----

Here's a basic usage example:

```php
<?php

require '/path/to/vendor/autoload.php';

class Dummy {
    function methodToCall(){
        return 'methodToCall';
    }
}

$resolver = new \Isholao\CallableResolver\Resolver();
$resolved = $resolver->resolve(Dummy::class.'->methodToCall'); 

\\or

$resolved = $resolver->resolve(function(){
    return 'methodToCall';
});

$resolved(); // 'methodToCall'

```

The library provides a helper useful for using a valid PHP string to call the class for example 'Class->method'

```php
<?php

require '/path/to/vendor/autoload.php';

class Dummy {
    function methodToCall($name){
        return $name;
    }
}

$dc = new \Isholao\CallableResolver\DeferredCallable(Dummy::class.'->methodToCall');
$dc('methodToCall'); // 'methodToCall'

//or

$dc = new \Isholao\CallableResolver\DeferredCallable(Dummy::class.'->methodToCall', new \CallableResolver\Resolver());
$dc('methodToCall'); // 'methodToCall'

```
