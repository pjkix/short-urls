<?php
/**
 * tr.im wrapper class for ShortUrl
 *
 * @see http://tr.im/website/api
 * @package		ShortUrl
 * @subpackage	ShortUrl_Trim
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 */

/** required base class */
require_once dirname(__FILE__) . '/../ShortUrl.php';

/**
 * subclass for tr.im url shortener
 *
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

