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

/**
 * required base class
 */
require_once('shortUrl.class.php');

/**
 * undocumented class
 *
 * @package default
 * @author PJ Khalil
 **/
class shortUrl_tinyUrl extends shortUrl 
{

	/**
	 * getShortUrl for tinyurl
	 *
	 * @param string $url 
	 * @return string $tinyurl or false on fail
	 * @author PJ Khalil
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

} // END: tinyUrl{}

/**
 * exception handler for tiny url specific errors
 *
 * @package default
 * @author PJ Khalil
 */
class tinyUrlException extends shortUrlException 
{

	// TODO: handle tiny url specific errors

} // END: tinyUrlException{}

?>

