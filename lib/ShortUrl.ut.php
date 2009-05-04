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
require_once 'shortUrl.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * psShortUrl test case.
 */
class psShortUrlTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var psShortUrl
	 */
	private $psShortUrl;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp ()
	{
		parent::setUp();
		// TODO Auto-generated psShortUrlTest::setUp()
		$this->psShortUrl = new psShortUrl(/* parameters */);
	}
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown ()
	{
		// TODO Auto-generated psShortUrlTest::tearDown()
		$this->psShortUrl = null;
		parent::tearDown();
	}
	/**
	 * Constructs the test case.
	 */
	public function __construct ()
	{	// TODO Auto-generated constructor
	}
	/**
	 * Tests psShortUrl->__construct()
	 */
	public function test__construct ()
	{
		// TODO Auto-generated psShortUrlTest->test__construct()
		$this->markTestIncomplete("__construct test not implemented");
		$this->psShortUrl->__construct(/* parameters */);
	}
}

