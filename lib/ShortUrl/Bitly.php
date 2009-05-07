<?php
/**
 * bit.ly wrapper class
 *
 * NOTE: bit.ly currently limits API users to no more than five concurrent connections from a single IP address
 * @see  http://code.google.com/p/bitly-api/wiki/ApiDocumentation
 * @package shortUrl
 * @subpackage shortUrl_bitly
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 */

/**
 * required base class
 */
require_once( dirname(__FILE__) . '/../ShortUrl.php');

/**
 * undocumented class
 */
class ShortUrl_Bitly extends ShortUrl
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
		$this->url = $url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
//			error_log('CACHE MISS!');
			$short_url = $this->_getShortUrl($url);
			$this->cacheSetUrl($url, $short_url);
		}
//		error_log('CACHE HIT!');
		$this->short_url = $short_url;
		return $this->cacheGetUrl($url);
	}

	// do the real shortening
	private function _getShortUrl($url){
		// http://api.bit.ly/shorten?version=2.0.1&longUrl=http://cnn.com&login=bitlyapidemo&apiKey=R_0da49e0a9118ff35f52f629d2d71bf07
		$service_string = 'http://api.bit.ly/shorten?version=2.0.1&longUrl=%s&login=%s&apiKey=%s';
		$service_call = sprintf($service_string, $url, $this->user, $this->api_key);
		$result = $this->restServiceCurl($service_call, $this->user, $this->pass);
		$result_array = json_decode($result, true);
		if ( $result_array['statusCode'] == 'OK' ) {
		$short_url = $result_array['results'][$url]['shortUrl'];
		return $short_url;
		} else {
//			return false;
			throw new ShortUrl_BitlyException("ERROR BAD RESPONSE FROM BIT.LY");
		}
	}

} // END: psShortUrl_trim{}

/**
 * exception handler for bit.ly url specific errors
 */
class ShortUrl_BitlyException extends ShortUrlException
{

	// TODO: handle bit.ly url specific errors

} // END: psShortUrl_trimException{}

?>