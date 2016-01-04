<?php

require __DIR__ . '/config.php';

use BuzzBoard\Client;

$client = new Client();

############################## AUTH ###################################
$client->setKey('YOUR_API_KEY');

#######################################################################
######################## REGENERATE AUDIT #############################
#######################################################################

$profile = new BuzzBoard\Profile($client);
$running = $profile->regenerate('LISTING_ID');

var_export($running); // bool
