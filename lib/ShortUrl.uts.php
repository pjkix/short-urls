<?php
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

