## The Buzzboard SDK for PHP

## Installation
The Buzzboard SDK can be installed via [composer](https://getcomposer.org/)

## Documentation
API [documentation](https://api.buzzboard.com/documentation)

## Usage
<pre>
require __DIR__ . '/vendor/autoload.php';

############################## AUTH ###################################
Buzzboard::setKey('YOUR_API_KEY');

// default response format is xml, for json format. Add the following line.
Buzzboard::$format = 'json';
#######################################################################
########################## CREATE LISTING #############################
#######################################################################

$data['business'] = 'The business name'; // required
$data['website'] = 'http://thebusinessname.com'; // optional
$data['phone'] = '123456798'; // required
$data['address'] = 'address'; // required
$data['city'] = 'city'; // required
$data['state'] = 'state'; // required
$data['zip'] = '123456'; // required
// ISO 3166-1 country code (http://en.wikipedia.org/wiki/ISO_3166-1)
$data['country_code'] = 'us';

// Account Manager (under which this listing should be listed on BuzzBoard)
$data['username'] = 'my_username'; // required
// Contact Person
$data['contact_name'] = 'John Doe'; // optional - contact persons name
$data['contact_email'] = 'contact_person@email.com'; // optional - contact persons email address
$data['contact_phone'] = '132-456-7891'; // optional - contact persons phone number

$response = Buzzboard::create($data);

echo PHP_EOL;
// for xml
$result = simplexml_load_string($response);
print_r($result);


#######################################################################
########################### GET AUDIT #################################
#######################################################################

$response = Buzzboard::audit('LISTING_ID');

// json
$result = json_decode($response);
print_r($result->response->listing);
// xml
$result = simplexml_load_string($response);
print_r($result->listing);

#######################################################################
######################## REGENERATE AUDIT #############################
#######################################################################

$response = Buzzboard::regenerate('LISTING_ID');
// json
$result = json_decode($response);
print_r($result->response->listing);
// xml
$result = simplexml_load_string($response);
print_r($result->listing);

</pre>
