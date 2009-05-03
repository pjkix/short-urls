<?php
/**
 * bit.ly wrapper class
 *
 * @see  http://code.google.com/p/bitly-api/wiki/ApiDocumentation
 * @package shortUrl
 * @subpackage shortUrl_bitly
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id: psShortUrl_bitly.php 31572 2009-05-02 00:14:16Z pkhalil $
 */

/**
 * required base class
 */
require_once('shortUrl-bitly.class.php');

/**
 * undocumented class
 *
 * @package default
 * @author PJ Khalil
 **/
class shortUrl_bitly extends shortUrl
{

	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
		$this->api_key = 'R_b2eb72dfa186b64f23dbef1fa32f7f61';
		$this->user = 'pjkix';
		$this->pass = '';
	}

	/**
	 * getShortUrl from bit.ly
	 *
	 * @param string $url
	 * @return string $short_url or false on fail
	 * @author PJ Khalil
	 * @todo add cacheing
	 */
	public function getShortUrl($url)
	{
		// http://api.bit.ly/shorten?version=2.0.1&longUrl=http://cnn.com&login=bitlyapidemo&apiKey=R_0da49e0a9118ff35f52f629d2d71bf07
		$service_string = 'http://api.bit.ly/shorten?version=2.0.1&longUrl=%s&login=%s&apiKey=%s';
		$service_call = sprintf($service_string, $url, $this->user, $this->api_key);
		$result = $this->restServiceCurl($service_call, $this->user, $this->pass);
		$result_array = json_decode($result, true);
		$short_url = $result_array['results'][$url]['shortUrl'];
		return $short_url;
	}

} // END: psShortUrl_trim{}

/**
 * exception handler for bit.ly url specific errors
 *
 * @package default
 * @author PJ Khalil
 */
class psShortUrl_trimException extends shortUrlException
{

	// TODO: handle bit.ly url specific errors

} // END: psShortUrl_trimException{}

?>