# Omnipay: Monetico

**Monetico driver for the Omnipay PHP payment processing library**


[![Build Status](https://travis-ci.org/dansmaculotte/omnipay-monetico.png?branch=master)](https://travis-ci.org/dansmaculotte/omnipay-monetico)
[![Latest Stable Version](https://poser.pugx.org/dansmaculotte/omnipay-monetico/version.png)](https://packagist.org/packages/dansmaculotte/omnipay-monetico)
[![Total Downloads](https://poser.pugx.org/dansmaculotte/omnipay-monetico/d/total.png)](https://packagist.org/packages/dansmaculotte/omnipay-monetico)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.6+. This package implements Monetico (Crédit Mutuel / CIC) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "dansmaculotte/omnipay-monetico": "^1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Monetico

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.
