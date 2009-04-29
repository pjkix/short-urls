<?php
/**
 * cli.gs wrapper class
 *
 * API KEY: b3e86e7644f1c6d22ca45eef6358e409
 * @example http://cli.gs/api/v1/cligs/create?url=1&title=2&key=3&appid=4
 * @package shortUrl
 * @subpackage cli.gs
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo make it work, abstract,  add caching
 */

/**
 * required base class
 */
require_once('shortUrl.class.php');

/**
 * undocumented class
 *
 * @package default
 * @author PJ Kix
 **/
class tinyUrl extends shortUrl 
{

	/**
	 * getShortUrl for tinyurl
	 *
	 * @param string $url 
	 * @return string $tinyurl or false on fail
	 * @author PJ Kix
	 */
	public function getShortUrl($url) 
	{
		$tiny = file_get_contents('http://tinyurl.com/api-create.php?url=' . $url);
		if ( strlen($tiny) > 0 ) {
			return $tiny;
		} else {
			return false;
		}
	}

} // END tinyUrl{}

/**
 * undocumented class
 *
 * @package default
 * @author PJ Kix
 */
class tinyUrlException extends shortUrlException 
{

	// handle tiny url specific errors

} // END tinyUrlException{}

?>

