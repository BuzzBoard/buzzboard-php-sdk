# BuzzBoard SDK for PHP

[![Build Status](https://scrutinizer-ci.com/g/buzzboard/buzzboard-php-sdk/badges/build.png?b=master)](https://travis-ci.org/buzzboard/buzzboard-php-sdk)
[![Latest Stable Version](https://img.shields.io/badge/Latest%20Stable-master-blue.svg)](https://packagist.org/packages/buzzboard/buzzboard-php-sdk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/BuzzBoard/buzzboard-php-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/BuzzBoard/buzzboard-php-sdk/?branch=master)

## Installation
The BuzzBoard SDK can be installed via [composer](https://getcomposer.org/)
```php
composer require buzzboard/buzzboard-php-sdk
```

## Documentation
API [documentation](https://api.buzzboard.com/documentation) &amp; [Response Codes](https://api.buzzboard.com/documentation/#api-ResponseCodes)

## Authentication
```php
require __DIR__ . '/vendor/autoload.php';
use BuzzBoard\Client;

$client = new Client('YOUR_API_KEY');
```

## Add Profile
```php
$profile = new BuzzBoard\Profile($client);
$profile->business = 'The business name'; // required
$profile->website = 'http://thebusinessname.com'; // optional
$profile->phone = '123456798'; // required
$profile->address = 'street address'; // required
$profile->city = 'city'; // required
$profile->state = 'state'; // required
$profile->zip = '50001'; // required
// ISO 3166-1 country code (http://en.wikipedia.org/wiki/ISO_3166-1)
$profile->country_code = 'us';

// Account Manager (under which this listing should be listed on BuzzBoard)
$profile->username = 'my_username'; // required
// Contact Person
$profile->contact_name = 'John Doe'; // optional - contact persons name
$profile->contact_email = 'john@example.com'; // optional - contact persons email address
$profile->contact_phone = '132-456-7891'; // optional - contact persons phone number

// Profile ID
$id = $profile->save();

```

## Get Profile
```php
$profile = new BuzzBoard\Profile($client);
$details = $profile->get($id);

print_r($details);
```

## Regenerate Profile
```php
$profile = new BuzzBoard\Profile($client);
$running = $profile->regenerate('PROFILE_ID');

var_export($running); // boolean
```


