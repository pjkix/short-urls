<?php
/**
 * tr.im wrapper class
 *
 * @see http://tr.im/website/api
 * @package shortUrl
 * @subpackage shortUrl_trim
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id: Trim.php 31599 2009-05-04 23:53:32Z pkhalil $
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
class psShortUrl_trim extends ShortUrl
{

	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	/**
	 * getShortUrl from tr.im
	 *
	 * @param string $url
	 * @return string $short_url or false on fail
	 * @author PJ Khalil
	 */
	public function getShortUrl($url)
	{

		$this->url = $url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
			$short_url = $this->restServiceFGC('http://api.tr.im/api/trim_simple?url=' . $url);
			$this->cacheSetUrl($url, $short_url);
		}
		$this->short_url = $short_url;
		return $this->cacheGetUrl($url);
	}

} // END: psShortUrl_trim{}

/**
 * exception handler for tr.im url specific errors
 *
 * @package default
 * @author PJ Khalil
 */
class psShortUrl_trimException extends ShortUrlException
{

	// TODO: handle tr.im url specific errors

} // END: psShortUrl_trimException{}

?>

