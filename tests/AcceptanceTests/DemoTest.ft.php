<?php
/**
 * TODO: Functional Tests for demo page ... using PHPUnit + selenium ... maybe even cruisecontrol :)
 */

/** PHPUnit_Extensions_SeleniumTestCase */
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

// require_once dirname(__FILE__) . '/../phpunit-bootstrap.php';

/**
 * ShortUrl Functional Acceptance Tests
 * @group ShortUrlAcceptance
 */
class DemoTest extends PHPUnit_Extensions_SeleniumTestCase
{
	
	// public static $browsers = array(
	//   array(
	// 	'name'	  => 'Firefox on mac',
	// 	'browser' => '*firefox',
	// 	'host'	  => 'localhost',
	// 	'port'	  => 4444,
	// 	'timeout' => 30000,
	//   ),
	//   array(
	// 	'name'	  => 'Safari on MacOS X',
	// 	'browser' => '*safari',
	// 	'host'	  => 'localhost',
	// 	'port'	  => 4444,
	// 	'timeout' => 30000,
	//   ),
	//   array(
	// 	'name'	  => 'Safari on Windows Vista',
	// 	'browser' => '*custom C:\Program Files\Safari\Safari.exe -url',
	// 	'host'	  => '192.168.1.140',
	// 	'port'	  => 4444,
	// 	'timeout' => 30000,
	//   ),
	//   array(
	// 	'name'	  => 'Internet Explorer on Windows Vista',
	// 	'browser' => '*iexplore',
	// 	'host'	  => '192.168.1.140',
	// 	'port'	  => 4444,
	// 	'timeout' => 30000,
	//   )
	// );
	
	function setUp()
	{
		// $this->setBrowser("*firefox");
		$this->setBrowserUrl("http://localhost/");
	}

	function testShortUrl()
	{
		$this->open("/~pjkix/projects/short-urls/demo.phtml");
		try {
			$this->assertTrue($this->isTextPresent("exact:http://tinyurl.com/kotu"));
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->toString());
		}
	}
}


?>