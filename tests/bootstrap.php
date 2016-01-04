<?php

date_default_timezone_set('America/New_York');

require_once __DIR__ . '/../vendor/autoload.php';

use BuzzBoard\ClientTest;

// Delete the temp test user after all tests have fired
register_shutdown_function(function () {
    print "\nTotal requests made : " . ClientTest::$requestCount . "\n\n";
});
