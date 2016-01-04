<?php

date_default_timezone_set('America/New_York');

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define('TEST_API_KEY', '');
define('TEST_PROFILE_ID', '');
define('TEST_USERNAME', '');

echo PHP_EOL;
print "API_KEY = " . TEST_API_KEY . PHP_EOL;

# just to log while were testing
register_shutdown_function(function () {
    print "\nTotal requests made : " . BuzzBoard\Network\Http::$requestCount . "\n\n";
});
