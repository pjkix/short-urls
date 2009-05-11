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
 * @group ShortUrl
 */
class ShortUrlTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ShortUrl
	 */
	private $ShortUrl; // instance of the class we're testing
	private $url; // fixture for url test

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp ()
	{
		parent::setUp();
		$this->ShortUrl = ShortUrlFactory::getUrlService(); // test all the types?
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
		$this->url = 'http://example.com/';
	}

	// real tests below ...

	/**
	 * tests the main function
	 *
	 */
	public function testGetShortUrl()
	{
		$short_url = $this->ShortUrl->getShortUrl($this->url);
		$this->assertEquals('http://tinyurl.com/kotu', $short_url); // this should work for tinyurl.com
		// make sure bad url fails
	}

	/**
	 * test caching functions
	 *
	 */
	public function testCacheSetUrl() {
		$this->markTestIncomplete('no cache testing yet ... ');
	}
	
	/**
	 * test caching functions
	 *
	 */
	public function testCacheGetUrl() {
		$this->markTestIncomplete('no cache testing yet ... ');
	}
	
	/**
	 * test curl
	 *
	 */
	public function testRestServiceCurl()
	{
		$this->markTestIncomplete('no curl testing yet ... ');
	}
	
	public function testrestServiceFGC()
	{
		$this->markTestIncomplete('no fgc testing yet ...');
	}

	// add more tests here ...


} // END: ShortUrlTest{}



/**
 * ShortUrlFactory test case.
 * @group ShortUrl
 */
class ShortUrlFactoryTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ShortUrlFactory
	 */
	private $ShortUrlFactory;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp ()
	{
		parent::setUp();
		$this->ShortUrlFactory = new ShortUrlFactory(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown ()
	{
		$this->ShortUrlFactory = null;
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct ()
	{
		// nothing to see here
	}

	// real tests below ...

	/**
	 * Tests ShortUrlFactory->__construct()
	 */
	public function test__construct ()
	{
		$this->markTestIncomplete("__construct test not implemented");
		$this->ShortUrlFactory->__construct(/* parameters */);
		// make sure we get a list of services
	}

	/**
	 * Tests ShortUrlFactory::getUrlService()
	 */
	public function testGetUrlService ()
	{
		$this->markTestIncomplete("getUrlService test not implemented");
		$this->service = ShortUrlFactory::getUrlService(/* parameters */);
		// 1. make sure we get a default service
		// 2. make sure it works with params
		// 3. make sure it throws exceptions on breaking
	}

	/**
	 * Tests ShortUrlFactory::getUrlServices()
	 */
	public function testGetUrlServices ()
	{
		$this->markTestIncomplete("getUrlServices test not implemented");
		$this->services = ShortUrlFactory::getUrlServices();
		// make sure we get list of services back
	}



} // END: ShortUrlFactoryTest{}


