<?php

require __DIR__ . '/config.php';

use BuzzBoard\Client;

############################## AUTH ###################################
$client = new Client('YOUR_API_KEY');

#######################################################################
########################### GET AUDIT #################################
#######################################################################

$categories = (new BuzzBoard\Categories($client))
        ->all();

print_r($categories);