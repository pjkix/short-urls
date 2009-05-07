<?php
/**
 * Unit Tests for ShortUrl Class
 *
 * @package Tests
 * @subpackage shortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work
 * @example tinyurl should return "http://tinyurl.com/kotu" for the url "http://example.com/"
 */

/**
 * required files and libs
 */
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'ShortUrl.ut.php';

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
	}
	/**
	 * Creates the suite.
	 */
	public static function suite ()
	{
		return new self();
	}
}

