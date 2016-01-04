<?php

require __DIR__ . '/config.php';

use BuzzBoard\Client;

############################## AUTH ###################################
$client = new Client('YOUR_API_KEY');

#######################################################################
########################## CREATE PROFILE #############################
#######################################################################

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

// Listing ID
$id = $profile->save();