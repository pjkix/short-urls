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
 * cli.gs url shortener
 *
 */
class shortUrl_cligs extends shortUrl
{
	private $api_key = 'b3e86e7644f1c6d22ca45eef6358e409';
	
	public function getShortUrl($url) {
		$api_key = $this->api_key;
		$app_id = self::API_CLIENT;
		$title = 'test-app'; // this should be the link title
		
		$api_string = 'http://cli.gs/api/v1/cligs/create?url=%s&title=%s&key=%s&appid=%s';
		$api_call = sprintf($api_string, $url, $title, $api_key, $app_id);		
		$short_url = file_get_contents($api_call); //@todo might want to use curl here
		
		if ( strlen($short_url ) > 0) {
			return $short_url;
		} else {
			return false;
		}
	}

}

/**
 * cli.gs Exception Handler
 *
 */
class shortUrl_cligsException extends shortUrlException
{
	// TODO - Insert your code here
}


?>
