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
final class ShortUrl_Tinyurl extends ShortUrl
{

	/** init */
	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	/**
	 * private getShortUrl for tinyurl
	 *
	 * ?? static? can't use this->
	 * @param string $url
	 * @return string $tinyurl or false on fail
	 * @author PJ Khalil
	 */
	public function _getShortUrl($url) {
		if ( function_exists('curl_init') ) {
			return $this->restServiceCurl('http://tinyurl.com/api-create.php?url=' . $url);
		} else {
			return $this->restServiceFGC('http://tinyurl.com/api-create.php?url=' . $url);
		}
	}

} // END: tinyUrl{}


?>

