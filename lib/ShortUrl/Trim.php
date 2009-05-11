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
require_once dirname(__FILE__) . '/../ShortUrl.php';

/**
 * undocumented class
 *
 * @package default
 * @author PJ Khalil
 **/
class ShortUrl_Trim extends ShortUrl
{

	/** init */
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
	public function _getShortUrl($url)
	{
			return $this->restServiceFGC('http://api.tr.im/api/trim_simple?url=' . $url);
	}

} // END: psShortUrl_trim{}


?>

