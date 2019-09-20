# Czech Bank Account Symfony integration

[![Build Status](https://travis-ci.com/czechphp/czech-bank-account-bundle.svg?branch=master)](https://travis-ci.com/czechphp/czech-bank-account-bundle)
[![codecov](https://codecov.io/gh/czechphp/czech-bank-account-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/czechphp/czech-bank-account-bundle)

Symfony integration of [czechphp/czech-bank-account](https://github.com/czechphp/czech-bank-account) library.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require czechphp/czech-bank-account-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require czechphp/czech-bank-account-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Czechphp\CzechBankAccountBundle\CzechBankAccountBundle::class => ['all' => true],
];
```

## Documentation

* [Constraints](Resources/doc/constraints.md)
