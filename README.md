# Zenvia PHP

> # :warning: Under Development :construction:

## Introduction
This package integrate the Zenvia SMS Gateway API 2.0 with your PHP application, built with PSR-7 in mind.

## Installation

> Not work for now!

This project follow the [psr-7](http://www.php-fig.org/psr/psr-7/) standards and no have a dependecy of an specific HTTP client. You need require a library for send the Http requests manually, at your choice. 
Consult this list to find a client that support [php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation). 
For more information about virtual packages please refer to [Httplug](http://docs.php-http.org/en/latest/httplug/users.html). Example:
```bash
composer require php-http/guzzle6-adapter
```

Then install this package with composer:
```bash
composer require artesaos/zenvia-php
```

## Usage

First, see the [Zenvia API Documentation](http://docs.zenviasms.apiary.io/#reference/servicos-da-api/envio-de-um-unico-sms) for view the structure of requests and responses.

### Sending SMS
The class you need use for sending sms is the `Artesaos\Zenvia\SMS.php`.
Let`s get started sending one sms:
```php
$response = (new Artesaos\Zenvia\SMS('your_account','your_password'))->send(['id'=>'001','from'=>'sender','msg'=>'message']);
```

The send method return for default a `psr7` response, but you can choose the response type, passing a second argument to the send method.
This argument is a string and need to be one of: `array`,`obj`,`string`,`stream`,`simple_xml` or `psr7`(default).
Example:
```php
$response = (new Artesaos\Zenvia\SMS('your_account','your_password'))->send(['id'=>'001','from'=>'sender','msg'=>'message'],'simple_xml');
```

If you need convert your psr7 response to one of the response types manually, use the `ResponseHandler` class:
```php
Artesaos\Zenvia\Http\ResponseHandler::convert($response,$type)
```