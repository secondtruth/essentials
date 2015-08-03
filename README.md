FlameCore Essentials
====================

[![Latest Stable](http://img.shields.io/packagist/v/flamecore/essentials.svg)](https://packagist.org/packages/flamecore/essentials)
[![Build Status](https://img.shields.io/travis/FlameCore/Essentials.svg)](https://travis-ci.org/FlameCore/Essentials)
[![Scrutinizer](http://img.shields.io/scrutinizer/g/FlameCore/Essentials.svg)](https://scrutinizer-ci.com/g/FlameCore/Essentials)
[![Coverage](http://img.shields.io/scrutinizer/coverage/g/FlameCore/Essentials.svg)](https://scrutinizer-ci.com/g/FlameCore/Essentials)
[![License](http://img.shields.io/packagist/l/flamecore/essentials.svg)](http://www.flamecore.org/projects/essentials)

This library provides essential helper classes for Social Networking sites.


Features
--------

* **Formatters:** Format meta information and text fragments

    Classes: `LinkFormatter`, `RelativeTimeFormatter`

* **Text Parsers:** Parse and format all types of text

    Classes: `SimpleTextParser`, `BBCodeParser`

* **Helpers:** Many useful helper classes

    Classes: `KeywordsFinder`, `Slugifier`, `WordlistGenerator`


Installation
------------

### Install via Composer

Create a file called `composer.json` in your project directory and put the following into it:

```
{
    "require": {
        "flamecore/essentials": "0.1.*"
    }
}
```

[Install Composer](https://getcomposer.org/doc/00-intro.md#installation-nix) if you don't already have it present on your system:

    $ curl -sS https://getcomposer.org/installer | php

Use Composer to [download the vendor libraries](https://getcomposer.org/doc/00-intro.md#using-composer) and generate the vendor/autoload.php file:

    $ php composer.phar install

To make use of the API, include the vendor autoloader and use the classes:

```php
namespace Acme\MyApplication;

use FlameCore\Essentials\KeywordsFinder;

require 'vendor/autoload.php';
```


Requirements
------------

* You must have at least PHP version 5.4 installed on your system.


Contributors
------------

If you want to contribute, please see the [CONTRIBUTING](CONTRIBUTING.md) file first.

Thanks to the contributors:

* Christian Neff (secondtruth)
