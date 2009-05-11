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
require_once 'ShortUrl.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ShortUrl test case.
 */
class ShortUrlTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ShortUrl
	 */
	private $ShortUrl;
	private $url;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp ()
	{
		parent::setUp();
		$this->ShortUrl = new ShortUrl(/* parameters */);
	}
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown ()
	{
		$this->ShortUrl = null;
		parent::tearDown();
	}
	/**
	 * Constructs the test case.
	 */
	public function __construct ()
	{

		$this->url = 'http://example.com';
	}
	/**
	 * Tests ShortUrl->__construct()
	 */
	public function test__construct ()
	{
		$this->ShortUrl->__construct(/* parameters */);
		$this->assertNull($this->ShortUrl->short_url);
	}


	public function testGetShortUrl()
	{
		$short_url = $this->ShortUrl->getShortUrl($this->url);
		$this->assertEquals($this->url, $short_url); // make sure we get something back
		// var_dump($short_url);die;
	}



} // END: ShortUrlTest{}

