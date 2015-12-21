<?php

/*
 * Response codes : http://api.buzzboard.com/documentation/responseCodes/
 */

require __DIR__ . '/vendor/autoload.php';

############################## AUTH ###################################
BuzzBoard::setKey('YOUR_API_KEY');

// default response format is xml, for json format. Add the following line.
BuzzBoard::$format = 'json';

#######################################################################
######################## REGENERATE AUDIT ############################
#######################################################################

$response = BuzzBoard::regenerate('LISTING_ID');

// json
//$result = json_decode($response);
//print_r($result->response->listing);
// xml
$result = simplexml_load_string($response);
print_r($result->listing);
