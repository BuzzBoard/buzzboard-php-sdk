<?php

date_default_timezone_set('America/New_York');

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define('TEST_API_KEY', '37a749d808e46495a8da1e5352d03cae');
define('TEST_PROFILE_ID', '00864ca8eafb828b2a0ffd20c8cae7e8');
define('TEST_USERNAME', 'qasalesrep1@vsplash.net');

echo PHP_EOL;
print "API_KEY = " . TEST_API_KEY . PHP_EOL;

# just to log while were testing
register_shutdown_function(function () {
    print "\nTotal requests made : " . BuzzBoard\Network\Http::$requestCount . "\n\n";
});
