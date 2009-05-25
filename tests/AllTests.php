<?php


// Set error reporting to highest level
error_reporting( E_ALL | E_STRICT );

// Allow time for the tests to run. I've scheduled a maximum of 3 minutes here.
set_time_limit(180);


require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';



?>