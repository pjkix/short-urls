<?php
/**
 * cli.gs wrapper class
 *
 * API KEY: b3e86e7644f1c6d22ca45eef6358e409
 * @example http://cli.gs/api/v1/cligs/create?url=1&title=2&key=3&appid=4
 * NOTES: cligs is a weird shortener ... it offers stats but ...
 * - they make a new short url each time??? - this will screw up cacheing too
 * - they let you edit the title, url, and even short url???
 * - you can redirect people from certain countries???
 * @see http://blog.cli.gs/api
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
require_once( dirname(__FILE__) . '/../ShortUrl.php');

/**
 * cli.gs url shortener
 *
 */
class ShortUrl_Cligs extends ShortUrl
{
	private $api_key = 'b3e86e7644f1c6d22ca45eef6358e409';

	public function __construct() {
		$this->class = __CLASS__; // need this to pass to the parent for cache key
	}

	public function getShortUrl($url, $title = null , $cache = false) {
		$this->url = $url;
		$api_key = $this->api_key;
		$app_id = self::API_CLIENT;
		$title = 'test-app'; // this should be the link title

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

/**
 * cli.gs Exception Handler
 *
 */
class ShortUrl_CligsException extends ShortUrlException
{
	// TODO - Insert your code here
}


?>
