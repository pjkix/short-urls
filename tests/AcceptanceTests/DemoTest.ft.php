<?php
/**
 * TODO: Functional Tests for demo page ... using PHPUnit + selenium ... maybe even cruisecontrol :)
 */

/** PHPUnit_Extensions_SeleniumTestCase */
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

// require_once dirname(__FILE__) . '/../phpunit-bootstrap.php';

class DemoTest extends PHPUnit_Extensions_SeleniumTestCase
{
	
	public static $browsers = array(
	  array(
		'name'	  => 'Firefox on Linux',
		'browser' => '*firefox',
		'host'	  => 'my.linux.box',
		'port'	  => 4444,
		'timeout' => 30000,
	  ),
	  array(
		'name'	  => 'Safari on MacOS X',
		'browser' => '*safari',
		'host'	  => 'my.macosx.box',
		'port'	  => 4444,
		'timeout' => 30000,
	  ),
	  array(
		'name'	  => 'Safari on Windows XP',
		'browser' => '*custom C:\Program Files\Safari\Safari.exe -url',
		'host'	  => 'my.windowsxp.box',
		'port'	  => 4444,
		'timeout' => 30000,
	  ),
	  array(
		'name'	  => 'Internet Explorer on Windows XP',
		'browser' => '*iexplore',
		'host'	  => 'my.windowsxp.box',
		'port'	  => 4444,
		'timeout' => 30000,
	  )
	);
	
	function setUp()
	{
		// $this->setBrowser("*firefox");
		// $this->setBrowser("*safari"); // gets stuck ... maybe safari4?
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