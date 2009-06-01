<?php
/**
 * cli.gs wrapper class
 *
 * API KEY: b3e86e7644f1c6d22ca45eef6358e409
 * @ example http://cli.gs/api/v1/cligs/create?url=1&title=2&key=3&appid=4
 * NOTES: cligs is a weird shortener ... it offers stats but ...
 * - they make a new short url each time??? - this will screw up cacheing too
 * - they let you edit the title, url, and even short url???
 * - you can redirect people from certain countries???
 * @see http://blog.cli.gs/api
 * @package		ShortUrl
 * @subpackage	ShortUrl_Cligs
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
 * cli.gs url shortener
 *
 */
class ShortUrl_Cligs extends ShortUrl
{
	// api key
	private $api_key = 'b3e86e7644f1c6d22ca45eef6358e409';

	/** init */
	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	// overide to avoid cache
	public function getShortUrl($url) {
		return $this->_getShortUrl($url);
	}


	/**
	 * Cligs private method for shortening urls
	 *
	 * actually ... might want to override main pub method to avoid caching
	 * @param unknown_type $url
	 * @param unknown_type $title
	 * @param unknown_type $cache
	 * @return unknown
	 */
	public function _getShortUrl($url, $title = null , $cache = false) {
		$this->url = $url;
		$api_key = $this->api_key;
		$app_id = self::API_CLIENT;
		$this->title = $title; // this should be the link title

		$api_url = 'http://cli.gs/api/v1/cligs/create?url=%s&title=%s&key=%s&appid=%s';
		$api_call = sprintf($api_url, $url, $title, $api_key, $app_id);

		if ($cache){
			if ( ! $short_url =  $this->cacheGetUrl($url) ) {
				$short_url = $this->restServiceCurl($api_call);
				$this->cacheSetUrl($url, $short_url);
			}
		} else {
			$short_url = $this->restServiceCurl($api_call);
		}

		$this->short_url = $short_url;
		return $short_url;
	}

}


?>
