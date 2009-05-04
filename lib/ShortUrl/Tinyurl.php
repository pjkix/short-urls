<?php
/**
 * tinyUrl wrapper class
 *
 * @package shortUrl
 * @subpackage shortUrl_tinyurl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work, abstract,  add caching
 */

/** required base class */
require_once( dirname(__FILE__) . '/../ShortUrl.php');

/**
 * tiny url service
 */
final class ShortUrl_TinyUrl extends ShortUrl
{

	/** init */
	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	/**
	 * getShortUrl for tinyurl 
	 * 
	 * ?? static? can't use this->
	 * @param string $url
	 * @return string $tinyurl or false on fail
	 * @author PJ Khalil
	 */
	public function getShortUrl($url)
	{
		$this->url = $url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
			$short_url = $this->getTinyUrl($url);
			$this->cacheSetUrl($url, $short_url);
		}
		$this->short_url = $short_url;
		return $short_url;
	}

	private function getTinyUrl($url) {
		if ( function_exists('curl_init') ) {
			return $this->restServiceCurl('http://tinyurl.com/api-create.php?url=' . $url);
		} else {
			return $this->restServiceFGC('http://tinyurl.com/api-create.php?url=' . $url);
		}
	}

} // END: tinyUrl{}

/**
 * exception handler for tiny url specific errors
 *
 */
class ShortUrl_TinyUrlException extends ShortUrlException
{

	// TODO: handle tiny url specific errors

} // END: tinyUrlException{}

?>

