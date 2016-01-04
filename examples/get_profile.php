<?php

require __DIR__ . '/config.php';

use BuzzBoard\Client;

$client = new Client();

############################## AUTH ###################################
$client->setKey('YOUR_API_KEY');

#######################################################################
########################### GET AUDIT #################################
#######################################################################

$profile = new BuzzBoard\Profile($client);
$details = $profile->get($id);

print_r($details);
