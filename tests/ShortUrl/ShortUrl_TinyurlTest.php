<?php
require_once 'ShortUrl/Tinyurl.php';
require_once 'PHPUnit/Framework/TestCase.php';
/**
 * ShortUrl_Tinyurl test case.
 */
class ShortUrl_TinyurlTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ShortUrl_Tinyurl
	 */
	private $ShortUrl_Tinyurl;
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp ()
	{
		parent::setUp();
		// TODO Auto-generated ShortUrl_TinyurlTest::setUp()
		$this->ShortUrl_Tinyurl = new ShortUrl_Tinyurl(/* parameters */);
	}
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown ()
	{
		// TODO Auto-generated ShortUrl_TinyurlTest::tearDown()
		$this->ShortUrl_Tinyurl = null;
		parent::tearDown();
	}
	/**
	 * Constructs the test case.
	 */
	public function __construct ()
	{	// TODO Auto-generated constructor
	}
	/**
	 * Tests ShortUrl_Tinyurl->__construct()
	 */
	public function test__construct ()
	{
		// TODO Auto-generated ShortUrl_TinyurlTest->test__construct()
		$this->markTestIncomplete("__construct test not implemented");
		$this->ShortUrl_Tinyurl->__construct(/* parameters */);
	}
	/**
	 * Tests ShortUrl_Tinyurl->_getShortUrl()
	 */
	public function test_getShortUrl ()
	{
		// TODO Auto-generated ShortUrl_TinyurlTest->test_getShortUrl()
		$this->markTestIncomplete("_getShortUrl test not implemented");
		$this->ShortUrl_Tinyurl->_getShortUrl(/* parameters */);
	}
}

