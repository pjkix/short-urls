<?php

// Set error reporting to highest level
error_reporting( E_ALL | E_STRICT );

// Allow time for the tests to run. I've scheduled a maximum of 3 minutes here.
set_time_limit(180);

// set lib path
defined('LIB_PATH')
	|| define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));
	
	set_include_path(implode(PATH_SEPARATOR, array(
		LIB_PATH,
		get_include_path(),
	)));



/**
 * Database connection details for use in the
 * Acceptance Tests for setup/teardown data.
 */
define('TESTS_DB_DBTYPE', 'Pdo_Mysql');
define('TESTS_DB_DBNAME', 'devzone');
define('TESTS_DB_PORT', '');
define('TESTS_DB_HOST', '127.0.0.1');
define('TESTS_DB_USER', 'root');
define('TESTS_DB_PASSWORD', '');

/**
 * Selenium Settings for Acceptance Testing
 */
define('TESTS_SELENIUM_BASEURL', 'http://localhost/projects/devzone/trunk/www');
define('TESTS_SELENIUM_BROWSER', '*firefox');
define('TESTS_SELENIUM_DEFAULT_TIMEOUT', 30000); // in milliseconds!
	
?>