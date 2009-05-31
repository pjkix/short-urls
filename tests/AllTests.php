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
require_once 'AcceptanceTestSuite.php';

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
 
		$suite->addTest(AcceptanceTests_AllTests::suite());

		// $suite->addTest('ShortUrlTestSuite');
		// $suite->addTestSuite('ShortUrlTest');
		$suite->addTestSuite('ShortUrlSuite');
		

		return $suite;
	}
}
 
if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
	AllTests::main();
}