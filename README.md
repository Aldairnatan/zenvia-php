# Zenvia PHP

[![Build Status](https://travis-ci.org/artesaos/zenvia-php.svg?branch=master)](https://travis-ci.org/artesaos/zenvia-php)

> # :warning: Under Development :construction:


## Introduction
This package integrate the Zenvia SMS Gateway API 2.0 with your PHP application, built with PSR-7 in mind.

## Table of Contents

- <a href="#installation">Installation</a>
- <a href="#usage">Usage</a>
    - <a href="#sending-sms">Sending SMS</a>
    - <a href="#sending-multiple-sms">Sending Multiple SMS</a>
    - <a href="#schedule-sms">Schedule SMS</a>
- <a href="#license">License</a>

## Installation

> Not work for now!

This project follow the [psr-7](http://www.php-fig.org/psr/psr-7/) standards and no have a dependency of an specific HTTP client. You need require a library for send the Http requests manually, at your choice. 
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
$sms = new Artesaos\Zenvia\SMS('your_account','your_password');
$response = $sms->send(['id'=>'001','from'=>'sender','to'=>'phone_number',''msg'=>'message']);
```

The send method return for default a `psr7` response, but you can choose the response type, passing a third argument to the send method. The second argument is a optional `aggregateId` parameter.
The response type argument is a string and need to be one of: `array`,`obj`,`string`,`stream`,`simple_xml` or `psr7`(default).
Example:
```php
$sms = new Artesaos\Zenvia\SMS('your_account','your_password');
$response = $sms->send(['id'=>'001','from'=>'sender','to'=>'phone_number','msg'=>'message'],'simple_xml');
```

If you need convert your psr7 response to one of the response types manually, see the [changing a response format](#changing-a-response-format) section.

### Sending Multiple SMS
For sending multiple SMS at a time, use the `sendMultiple` method instead of `send` method:
```php
$messages = [
    [
        'id'=>'001',
        'from'=>'sender',
        'to'=>'phone_number'
        'msg'=>'message'
    ],
    [
        'id'=>'002',
        'from'=>'sender',
        'to'=>'phone_number'
        'msg'=>'message'
    ],
];
$sms = new Artesaos\Zenvia\SMS('your_account','your_password');
$response = $sms->send($messages);
```
### Schedule SMS
You can schedule a text message to be sent passing a schedule attribute to the body of your sms:
```php
$sms = new Artesaos\Zenvia\SMS('your_account','your_password');
$response = $sms->send(['id'=>'001','from'=>'sender','to'=>'phone_number','msg'=>'message','schedule'=>'15/04/2016 17:10:23']);
```
By default the Zenvia API accepts the ISO format, someting like this `2016-04-15T17:10:23`. 
Thanks to Carbon extension for make this more easy.
Instead of a ISO date string, you may pass a variety of formats accepted by Carbon.

Example:
* `+1 day`
* `tomorrow 13:00`
* `this sunday 20:20:10`
* `17:10:23`
* `15/04/2016 17:10:23`

See more options on the [Carbon documentation](http://carbon.nesbot.com/docs/)

> Work in progress!

### License
This project is open-source and licensed under the MIT license
