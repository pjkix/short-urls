<?php
/**
 * Short URL Base Class
 *
 * @package		Utils
 * @subpackage	ShortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo clean up, abstract,  add caching
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
 * @package shortUrl
 * @author PJ Khalil
 */
class shortUrlFactory
{
	// service constants ... add new ones here
	const TINY_URL= 1;
	const BITLY_URL = 2;
	const CLIGS_URL = 3;
	const TRIM_URL = 4;
	const ISGD_URL = 5;



	public function __construct()
	{
		$this->serives = $this->getUrlServices();
	}

	// pretty basic for now, could automate this with some naming conventions service array
	public static function getUrlService($type = self::TINY_URL)
	{
		switch ($type) {
			case self::TINY_URL:
				require_once('shortUrl-tinyurl.class.php');
				return new shortUrl_tinyUrl();
			case self::BITLY_URL:
				require_once('shortUrl-bitly.class.php');
				return new shortUrl_bitly();
			case self::CLIGS_URL:
				require_once('shortUrl-cligs.class.php');
				return new shortUrl_cligs();
			default:
				throw new shortUrlException("Unknown Service Specified.");
		}
	}

	// maybe use this to build service types or for looping
	public static function getUrlServices() {
		return array('tinyurl', 'bitly', 'cligs', 'trim', 'isgd');
	}
} // END: shortUrlFactory{}

/**
 * short Url base class
 *
 * @package shortUrl
 * @author PJ Khalil
 */
class shortUrl implements iShortUrl
{
	// API constants
	const		API_VERSION = '1.0';
	const		API_CLIENT = 'shortUrl/bot';
	// API vars
	protected	$url = null;
	protected	$short_url = null;
	protected	$cache_time = 86400; // 1 day
	protected 	$class = __CLASS__; // hack for getting subclass name back to parent class

	/**
	 * generic for basic interface restrictions
	 *
	 * @param unknown_type $url
	 * @return unknown
	 */
	public function getShortUrl($url)
	{
		$this->url = $url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
			error_log('CACHE MISS!');
			$short_url = $url; // no shortening in base class
			$this->cacheSetUrl($url, $short_url);
		}
		return cacheGet($url);
	}

	/**
	 * set it and forget it
	 *
	 * @param unknown_type $url
	 * @param unknown_type $key
	 * @param unknown_type $expiry
	 */
	public function cacheSetUrl($url, $data, $expiry = null)
	{
		if (!$expiry) $expiry = $this->cache_time;
		require_once dirname(__FILE__) . '/memcache.class.php';
		$cache_name = $this->class .'-'.md5($url);
//		error_log(sprintf('ADDING: %s TO CACHE WITH KEY: %s AND EXPIRES %s', $data, $cache_name, $expiry));
		return cacheMemcache::set($cache_name,$data, false, $this->cache_time);
	}

	/**
	 * grab from cache
	 *
	 * @param unknown_type $url
	 * @return unknown
	 */
	protected function cacheGetUrl($url)
	{
		require_once dirname(__FILE__) . '/memcache.class.php';
		cacheMemcache::connect( array( array('localhost' => 11211) ) ); // normally this is done in the configs
		$cache_name = $this->class . '-' . md5($url);
//		error_log(sprintf('GETTING: %s FROM CACHE KEY %s', $url, $cache_name));
		return cacheMemcache::get($cache_name);
	}

	/**
	 * curl rest call
	 *
	 * @param string $url
	 * @return string on success false on fail
	 * @todo maybe make this more generic for base, can override ... detect curl? default fopen?
	 */
	public function restServiceCurl($url, $username = null, $pass = null)
	{
		error_log('USING CURL');
		$curl_options = array(
			CURLOPT_RETURNTRANSFER	=> true,		// return web page
			CURLOPT_HEADER			=> false,		// don't return headers
			CURLOPT_FOLLOWLOCATION	=> true,		// follow redirects
			CURLOPT_USERAGENT		=> self::API_CLIENT,	// who am i
			CURLOPT_AUTOREFERER		=> true,		 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT	=> 30,			// timeout on connect
			CURLOPT_TIMEOUT			=> 30,			// timeout on response
			CURLOPT_MAXREDIRS		=> 10,			// stop after 10 redirects
			CURLOPT_VERBOSE			=> 1			//debugging
		);
		if ($username && $pass) {			// authenticated
			$curl_options[]['CURLOPT_USERPWD'] =  $username .':' . $pass;
		}
		$ch = curl_init($url);
		curl_setopt_array($ch, $curl_options);
		$this->status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$result = curl_exec($ch);
		$this->err	= curl_errno($ch);
		$this->errmsg	= curl_error($ch) ;
		$this->header	= curl_getinfo($ch);
		curl_close($ch);
		return $result;
	}
	/**
	 * undocumented function
	 *
	 * @param string $url
	 * @return string on success false on fail
	 */
	public function restServiceFGC($url)
	{
		error_log('USING FGC');
		$result =  file_get_contents($url); // urlencode()?
		if ( strlen($result) > 0 ) {
			return $result;
		} else {
			return false;
	}

}

} // END shortUrl{}

/**
 * shortUrl Exception Handler
 *
 * @package default
 * @author PJ Kix
 */
class shortUrlException extends Exception {
	// try and handle errors here ...
} // END: shortUrlException{}

?>
