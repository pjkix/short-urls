<?php
/**
 * Unit Tests for ShortUrl Class
 *
 * @package Tests
 * @subpackage ShortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work with all subclasses
 */

/**
 * required files and libs
 */
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'lib/ShortUrlTest.php';

/**
 * Static test suite.
 */
class ShortUrlSuite extends PHPUnit_Framework_TestSuite
{
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct ()
	{
		$this->setName('ShortUrlSuite');
		$this->addTestSuite('ShortUrlTest');
		$this->addTestSuite('ShortUrlFactoryTest');
	}
	/**
	 * Creates the suite.
	 */
	public static function suite ()
	{
		return new self();
	}
}

