<?php
/**
 * Short Ulr Base Class
 */

/**
 * main api class
 */
require_once( __API_LIB_ROOT__ . 'psGateway.php' );

/**
 * short url interface?
 */
interface iShortUrl {
	public function getShortUrl($url);
}

/**
 * Enter description here...
 *
 */
class psShortUrl extends psGateway implements iShortUrl
{

	protected $type = self::TINY_URL; // default
	const TINY_URL = 1;
	const CLIGS_URL = 2;

	/**
	 *
	 */
	function __construct ($type = null)
	{
		if ($type) {
			if (!is_numeric($type)) {
				throw new psShortUrlException('NOT A VALID TYPE', 500);
			} else {
			$this->type = $type;
			}
		}
	}

	function getShortUrl($url) {
		// use the correct service

		switch ($this->type) {
			case self::CLIGS_URL :
				// do cligs stuff;
				psLoader::loadService('Cligs');
				$cligs = new psCligs();
				$cligs->getShortUrl($url); // might be better to just return a new object, factory style
			break;

			case self::TINY_URL :
			default:
				// default to tiny;
			break;
		}

	}

	function cacheGetUrl() {
		// look up url in cache
	}


}

class psShortUrlException extends Exception {}

?>
