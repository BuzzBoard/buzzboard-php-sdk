<?php

/*
 * Response codes : http://api.buzzboard.com/documentation/responseCodes/
 */

require __DIR__ . '/BuzzBoard.php';

############################## AUTH ###################################
BuzzBoard::setKey('YOUR_API_KEY');
//BuzzBoard::setKey('YOUR_API_KEY');

// default response format is xml, for json format. Add the following line.
BuzzBoard::$format = 'json';

#######################################################################
########################### GET AUDIT #################################
#######################################################################
# for json output, default is xml
//BuzzBoard::$responseFormat = 'json';

$response = BuzzBoard::audit('LISTING_ID');

// json
//$result = json_decode($response);
//print_r($result->response->listing);
// xml
$result = simplexml_load_string($response);
print_r($result->listing);
