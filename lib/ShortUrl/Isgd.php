<?php
/**
 * is.gd wrapper class
 *
 * @see http://is.gd/api_info.php
 * @package ShortUrl
 * @subpackage ShortUrl_isgd
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id: Isgd.php 31599 2009-05-04 23:53:32Z pkhalil $
 */

/** required base class */
require_once dirname(__FILE__) . '/../ShortUrl.php';

/**
 * subclass for is.gd url shortener
 *
 **/
class ShortUrl_isgd extends ShortUrl
{

	/** init */
	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	/**
	 * getShortUrl from is.gd
	 *
	 * @param string $url
	 * @return string $short_url or false on fail
	 */
	public function _getShortUrl($url)
	{
			return $this->restServiceFGC('http://is.gd/api.php?longurl=' . $url);
	}

} // END: psShortUrl_trim{}


?>

