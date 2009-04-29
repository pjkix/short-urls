<?php
/**
 * Short URL Base Class
 * @package		Utils
 * @subpackage	ShortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work, abstract,  add caching
 */

/**
 * short url interface
 */
interface iShortUrl {
	public function getShortUrl($url);
}

/**
 * Enter description here...
 *
 */
class shortUrl implements iShortUrl
{

	/**
	 * define some constants and properties
	 */
	protected $type = self::TINY_URL; // default
	const TINY_URL = 1;
	const CLIGS_URL = 2;

	/**
	 * set type on construct
	 */
	function __construct ($type = null)
	{
		if ($type) {
			if (!is_numeric($type)) {
				throw new psShortUrlException('NOT A VALID TYPE', 500);
			} else {
			$this->type = $type;
			}
		}
	}
	
	public function setType($type = null)
	{
		# code...
	}

	public function getShortUrl($url) {
		// use the correct service

		switch ($this->type) {
			case self::CLIGS_URL :
				// do cligs stuff;
				require_once('shortUrl-cligs.class.php');
				$cligs = new shortUrl_Cligs();
				$cligs->getShortUrl($url); // might be better to just return a new object, factory style
			break;

			case self::TINY_URL :
			default:
				// default to tiny;
			break;
		}

	}

	protected function cacheGetUrl($url) 
	{
		// look up url in cache
	}


}

/**
 * shortUrl Exception Handler
 *
 * @package default
 * @author PJ Kix
 */
class shortUrlException extends Exception {
	// try and handle errors here ... 
}

?>
