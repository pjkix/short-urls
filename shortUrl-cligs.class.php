<?php
/**
 * cli.gs wrapper class
 *
 * API KEY: b3e86e7644f1c6d22ca45eef6358e409
 * @example http://cli.gs/api/v1/cligs/create?url=1&title=2&key=3&appid=4
 */

//require_once( __API_LIB_ROOT__ . 'psGateway.php' );
require_once (__API_LIB_ROOT__ . 'psGateway/psShortUrl.php');

/**
 * cli.gs url shortener
 *
 */
class psCligs extends psShortUrl
{
	/**
	 *
	 */
	function __construct ()
	{
		parent::__construct();
		//TODO - Insert your code here
	}

	public function getShortUrl($url) {
		$api_key = 'b3e86e7644f1c6d22ca45eef6358e409';
		$app_id = 'mevio-test';
		$title = 'foo';
		$service = 'http://cli.gs/api/v1/cligs/create?url=%s&title=%s&key=%s&appid=%s';
		$api_call = sprintf($service, $url, $title, $api_key, $app_id);
		$short = file_get_contents($api_call); //@todo might want to use curl here
		if(strlen($short) > 0) {
			return $short;
		} else {
			return false;
		}
	}

}

/**
 * cli.gs Exception Handler
 *
 */
class psCligsException extends Exception
{
	// TODO - Insert your code here
}


?>
