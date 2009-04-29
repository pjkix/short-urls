<?php
require_once 'source/Ps/psGateway/psShortUrl.php';
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

