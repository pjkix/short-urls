<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AcceptanceTests_AllTests::main');
}
 
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

/**
 * Require setup Helper tasks
 */
require_once 'phpunit-bootstrap.php';
 
/**
 * Include test files
 */
require_once 'AcceptanceTests/DemoTest.ft.php';
 
class AcceptanceTests_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Short Url Demo :: Acceptance Tests');
 
        $suite->addTestSuite('DemoTest');
 
        return $suite;
    }
}
 
if (PHPUnit_MAIN_METHOD == 'AcceptanceTests_AllTests::main') {
    AcceptanceTests_AllTests::main();
}