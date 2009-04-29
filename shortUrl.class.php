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
 * short url interface for completeness/strictness
 */
interface iShortUrl {
	public function getShortUrl($url);
}

/**
 * short Url base class / factory?
 *
 * @package default
 * @author PJ Kix
 */
class shortUrl implements iShortUrl
{

	/**
	 * define some constants and properties
	 */
	protected $type = self::TINY_URL; // default
	const TINY_URL = 1;
	const CLIGS_URL = 2;
	const BITLY_URL = 3;

	/**
	 * set type on construct
	 */
	public function __construct ($type = null)
	{
		if ($type) {
			if (!is_numeric($type)) {
				throw new psShortUrlException('NOT A VALID TYPE', 500);
			} else {
			$this->type = (int) $type;
			}
		}
	}
	
	/**
	 * sets the type of url shortner
	 *
	 * @param string $type 
	 * @return void
	 * @author PJ Kix
	 */
	public function setType($type = null)
	{
		# code...
	}
	
	/**
	 * generic wrapper function for getting short urls
	 *
	 * @param string $url 
	 * @return void
	 * @author PJ Kix
	 */
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
	
	/**
	 * curl rest call
	 *
	 * @param string $url 
	 * @return void
	 * @author PJ Kix
	 */
	public function restServiceCurl($url)
	{
		# code...
	}
	/**
	 * undocumented function
	 *
	 * @param string $url 
	 * @return void
	 * @author PJ Kix
	 */
	public function restServiceFopen($url)
	{
		# code...
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



// zend factory example

class Configuration 
{ 
	const STORE_INI = 1; 
	const STORE_DB = 2; 
	const STORE_XML = 3; 
	public static function getStore($type = self::STORE_XML) 
	{ 
		switch ($type) { 
			case self::STORE_INI: 
				return new Configuration_Ini(); 
			case self::STORE_DB: 
				return new Configuration_DB(); 
			case self::STORE_XML: 
				return new Configuration_XML(); 
			default: 
				throw new Exception("Unknown Datastore Specified."); 
		} 
	} 
} 
class Configuration_Ini { 
	// ... 
} 
class Configuration_DB { 
	// ... 
} 
class Configuration_XML { 
	// ... 
} 
$config = Configuration::getStore(Configuration::STORE_XML); 

?>
