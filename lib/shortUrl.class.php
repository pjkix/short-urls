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
	public function getShortUrl($url); // KISS - basically all you need :)
}

/**
 * Factory for building the different object types transparently 
 *
 * @package default
 * @author PJ Khalil
 */
class shortUrlFactory 
{ 
	// service constants
	const TINY_URL= 1;
	const BITLY_URL = 2;
	const TRIM_URL = 3;
	const URLTEA_URL = 4;
	const CLIGS_URL = 5;

	// pretty basic for now, could automate this with some naming conventions	
	public static function getUrlService($type = self::TINY_URL) 
	{ 
		switch ($type) { 
			case self::TINY_URL: 
				require_once('shortUrl-tinyurl.class.php');
				return new shortUrl_tinyUrl(); 
			case self::BITLY_URL: 
				return new shortUrl_bitly(); 
			case self::CLIGS_URL: 
				require_once('shortUrl-cligs.class.php');
				return new shortUrl_cligs(); 
			default: 
				throw new shortUrlException("Unknown Service Specified."); 
		} 
	} 
}

/**
 * short Url base class
 *
 * @package default
 * @author PJ Kix
 */
class shortUrl implements iShortUrl
{
	const		API_VERSION = '1.0';
	const		API_CLIENT = 'shortUrl/bot';
	
	private		$api_key = '';
	protected	$url = null;
	protected	$short_url = null;
		
	// generic for basic interface restrictions
	public function getShortUrl($url)
	{
		if ( !cacheGetUrl($url) ) {
			// make short
			cacheSet($url);
		}
		return cacheGet($url);
	}
	
	public function cacheSetUrl($url, $key, $expiry)
	{
		# code...
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
	 * @todo maybe make this more generic for base, can override ... detect curl? default fopen?
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

?>
