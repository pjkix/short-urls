<?php
/**
 * is.gd wrapper class
 *
 * @see http://is.gd/api_info.php
 * @package shortUrl
 * @subpackage shortUrl_trim
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id: Isgd.php 31599 2009-05-04 23:53:32Z pkhalil $
 */

/**
 * required base class
 */
require_once dirname(__FILE__) . '/../psShortUrl.php';

/**
 * undocumented class
 *
 * @package default
 * @author PJ Khalil
 **/
class psShortUrl_isgd extends ShortUrl
{

	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	/**
	 * getShortUrl from is.gd
	 *
	 * @param string $url
	 * @return string $short_url or false on fail
	 * @author PJ Khalil
	 */
	public function getShortUrl($url)
	{
		$this->url = $url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
//			error_log('CACHE MISS!');
			$short_url = $this->restServiceFGC('http://is.gd/api.php?longurl=' . $url);
			$this->cacheSetUrl($url, $short_url);
		}
//		error_log('CACHE HIT!');
		$this->short_url = $short_url;
		return $this->cacheGetUrl($url);
	}

} // END: psShortUrl_trim{}

/**
 * exception handler for is.gd url specific errors
 *
 * @package default
 * @author PJ Khalil
 */
class psShortUrl_isgdException extends ShortUrlException
{

	// TODO: handle is.gd url specific errors

} // END: psShortUrl_trimException{}

?>

