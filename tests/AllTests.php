<?php
// this should run all unit and acceptance tests in a browser 

if (!defined('PHPUnit_MAIN_METHOD')) {
	define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}
 
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

/**
 * Require setup Helper tasks
 */
require_once 'phpunit-bootstrap.php';
 
// test suites
require_once 'AcceptanceTests/AllTests.php';

require_once 'ShortUrlTestSuite.php';
 
class AllTests
{
	public static function main()
	{
		PHPUnit_TextUI_TestRunner::run(self::suite());
	}
 
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('Short Url Demo');

		// unit test suite
		$suite->addTestSuite('ShortUrlSuite');
		
		// acceptance tests
		$suite->addTest(AcceptanceTests_AllTests::suite());

		return $suite;
	}
}
 
if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
	AllTests::main();
}


