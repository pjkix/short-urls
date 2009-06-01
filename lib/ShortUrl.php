<?php
/**
 * Short URL Base Class
 *
 * @category	WebServices
 * @package		ShortUrl
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id$
 * @todo 		simplify / streamline
 */

/**
 * short url interface for completeness/strictness
 */
interface iShortUrl
{
	/**
	 * basic public interface
	 *
	 * @param string $url long url
	 * @return string $short_url short url
	 */
	public function getShortUrl($url); // KISS - basically all you need :)
//	private function _getShortUrl($url); // the real magic
}

/**
 * Factory for building the different object types transparently
 *
 * Example:
 * <code>
 * require_once 'ShortUrl.php';
 *
 * $myShortUrl =  ShortUrlFactory::getUrlService(ShortUrlFactory::TINY_URL);
 * echo $myShortUrl->getShortUrl($url);
 * </code>
 * @example demo.phtml This example is in the "examples" subdirectory
 */
class ShortUrlFactory
{
	// service constants ... add new ones here
	const TINY_URL= 1;
	const BITLY_URL = 2;
	const CLIGS_URL = 3;
	const TRIM_URL = 4;
	const ISGD_URL = 5;

	/**
	 * Url Service object builder
	 *
	 * pretty basic for now, could automate this with some naming conventions
	 * service array
	 * @param string $type
	 * @return void
	 * @access public
	 * @static
	 * @throws ShortUrlException
	 */
	public static function getUrlService($type = self::TINY_URL)
	{
		switch ($type) 
		{
			case self::TINY_URL:
				require_once('ShortUrl/Tinyurl.php');
				return new ShortUrl_Tinyurl();
			case self::BITLY_URL:
				require_once('ShortUrl/Bitly.php');
				return new ShortUrl_Bitly();
			case self::CLIGS_URL:
				require_once('ShortUrl/Cligs.php');
				return new ShortUrl_Cligs();
			case self::TRIM_URL:
				require_once('ShortUrl/Trim.php');
				return new ShortUrl_Trim();
			case self::ISGD_URL:
				require_once('ShortUrl/Isgd.php');
				return new ShortUrl_Isgd();
			default:
				throw new ShortUrlException("Unknown Service Specified.");
		}
	}

	// maybe use this to build service types or for looping
	public static function getUrlServices() {
		$services = array();
		$services[]['tinyurl'] = array('name'=>'Tinyurl', 'site'=>'tinyrurl.com');

		return array('tinyurl'=> self::TINY_URL, 'bitly', 'cligs', 'trim', 'isgd');
	}

	/// build array of services and define constants??
	public function __construct()
	{
		$this->serives = $this->getUrlServices();
	}

	// might not be a good idea?
	function __autoload($class)
	{
		$filename = str_replace('_', DIRECTORY_SEPARATOR , $class) . '.php';
		@require_once $filename;
	}


} // END: ShortUrlFactory{}

/**
 * short Url base class
 */
abstract class ShortUrl implements iShortUrl
{
	// API constants
	const		API_VERSION = '1.0';
	const		API_CLIENT = 'ShortUrl/bot';
	// API vars
	protected	$url = 			null;
	protected	$short_url = 	null;
	protected	$cache_time = 	86400; // 1 day
	protected 	$class = 		__CLASS__; // hack for getting subclass name back to parent class
	public		$debug = 		false;

	/**
	 * basic interface provides caching for private _getShortUrl method
	 *
	 * @param string $url the url to be shortened
	 * @return string $short_url the short version of the url
	 * @assert ('http://example.com/') != 'http://example.com/'
	 */
	public function getShortUrl($url)
	{
		// check we have valid url
		$url_a = parse_url($url);
		if ( empty($url_a['host']) ) throw new ShortUrlException('Not a valid URL');
		$this->url = $url;
		if ($this->short_url) return $this->short_url;
		if ( ! $short_url =  $this->cacheGetUrl($url) ) {
			$this->debug('CACHE MISS!');
			if ( ! $short_url = $this->dbGetUrl($url) ) {
				$this->debug('DB MISS!');
				$short_url = $this->_getShortUrl($url);
				$this->dbSetUrl($url, $short_url);
			}
			$this->cacheSetUrl($url, $short_url);
		}
		$this->short_url = $short_url;
		return $short_url;
	}

	/**
	 * private method must be implemented in subclass
	 *
	 * @param string $url the long url
	 * @return string $short_url	the short url
	 */
	abstract function _getShortUrl($url);

	/**
	 * debug function
	 *
	 * @param string $msg
	 * @return void
	 */
	public function debug($msg = null, $obj = null,  $print = false)
	{
		if ($this->debug) {
			error_log($msg);
			if ($obj && $print) {
				echo $msg . PHP_EOL;
				var_dump($obj);
			}
		}
		// trigger_error('cacheMemcache::set() attempted with no connection present',E_USER_ERROR);
	}

	/**
	 * public setter for url
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl($url)
	{
		$url_a = parse_url($url);
		if ( empty($url_a['host']) ) throw new ShortUrlException('Not a valid URL');
		$this->url = $url;
	}

	/**
	 * save short url to db
	 *
	 * @param unknown_type $url
	 * @param unknown_type $short_url
	 */
	public function dbSetUrl($url, $short_url) {
		$this->debug(sprintf('ADDING LONG_URL: %s AND SHORT_URL: %s TO DB', $url, $short_url) );
		require_once dirname(__FILE__) . '/MyDb.php';
		$dbh = new MyDb;
		$sql = "INSERT INTO `short_urls` (`id`, `long_url`, `short_url`, `date_created`)
			VALUES (NULL, '%s', '%s', %s );"; // 2009-05-22 11:54:41
		$insert_sql = sprintf($sql, $url, $short_url, $dbh->quote( date('r') ) );
		$result = $dbh->query($insert_sql);
		return $result;
	}

	/**
	 * get short url from db
	 *
	 * @param unknown_type $url
	 * @return unknown
	 */
	public function dbGetUrl($url) {
		$this->debug(sprintf('GETTING: %s FROM DB', $url) );
		require_once dirname(__FILE__) . '/MyDb.php';
		$dbh = new MyDB;
		$sql = "SELECT `short_url` FROM `short_urls` WHERE `long_url` = '%s' LIMIT 1 ";
		$select_sql = sprintf($sql,$url);
		$result = $dbh->query($select_sql);
		$data = $result->fetch();
		return $data['short_url'];
	}

	/**
	 * set it and forget it
	 *
	 * @param	string	$url		the url we use for the key
	 * @param	string	$data		the short url to store
	 * @param	int		$expiry		time in seconds to cache the entry
	 * @return	boolean			true on success false on fail
	 */
	protected function cacheSetUrl($url, $data, $expiry = null)
	{
		if (!class_exists('Memcache')) return false;
		if (!$expiry) $expiry = $this->cache_time;
		require_once dirname(__FILE__) . '/memcache.class.php';
		$cache_name = $this->class .'-'.md5($url);
		$this->debug(sprintf('ADDING: %s TO CACHE WITH KEY: %s AND EXPIRES %s', $data, $cache_name, $expiry));
		return cacheMemcache::set($cache_name,$data, false, $expiry);
	}

	/**
	 * grab from cache
	 *
	 * @param 	string	$url		key for our cache
	 * @return 	string	$short_url	data from cache
	 */
	protected function cacheGetUrl($url)
	{
		if (!class_exists('Memcache')) return false;
		require_once dirname(__FILE__) . '/memcache.class.php';
		if (! cacheMemcache::connect( array( array('localhost' => 11211) ) ) ) return false; // normally this is done in the configs
		$cache_name = $this->class . '-' . md5($url);
		$this->debug(sprintf('GETTING: %s WITH CACHE KEY: %s', $url, $cache_name));
		return @cacheMemcache::get($cache_name);
	}

	/**
	 * make a remote request using curl
	 *
	 * @param string $url
	 * @return mixed $result on success false on fail
	 * @todo maybe make this more generic for base, can override ... detect curl? default fopen?
	 */
	protected function restServiceCurl($url, $username = null, $pass = null)
	{
		$this->debug('USING CURL');
		$curl_options = array(
			CURLOPT_RETURNTRANSFER	=> true,		// return web page
			CURLOPT_HEADER			=> false,		// don't return headers
			CURLOPT_FOLLOWLOCATION	=> true,		// follow redirects
			CURLOPT_USERAGENT		=> self::API_CLIENT,	// who am i
			CURLOPT_AUTOREFERER		=> true,		 // set referer on redirect
			CURLOPT_CONNECTTIMEOUT	=> 30,			// timeout on connect
			CURLOPT_TIMEOUT			=> 30,			// timeout on response
			CURLOPT_MAXREDIRS		=> 10,			// stop after 10 redirects
			CURLOPT_VERBOSE			=> 1			//debugging
		);
		if ($username && $pass) {			// authenticated
			$curl_options[]['CURLOPT_USERPWD'] =  $username .':' . $pass;
		}
		$ch = curl_init($url);
		curl_setopt_array($ch, $curl_options);
		$this->status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$result = curl_exec($ch);
		$this->err	= curl_errno($ch);
		$this->errmsg	= curl_error($ch) ;
		$this->header	= curl_getinfo($ch);
		curl_close($ch);
		return $result;
	}

	/**
	 * make a remote request using file_get_contents()
	 *
	 * @param string $url
	 * @return string on success false on fail
	 * @depricated use curl instead
	 */
	protected function restServiceFGC($url)
	{
		$this->debug('USING FGC');
		$result =  file_get_contents($url); // urlencode()?
		if ( strlen($result) > 0 ) {
			return $result;
		} else {
			return false;
		}
	}

} // END ShortUrl{}

/**
 * ShortUrl Exception Handler
 */
class ShortUrlException extends Exception
{

	// try and handle errors here ...

} // END: ShortUrlException{}


/**
* ShortUrlUtils for setting up, upgrading, etc
*/
class ShortUrlUtil
{

	public static function setUpDbSqlLite()
	{
		// create new database (OO interface)
		$db = new SQLiteDatabase("data/db.sqlite");

		// create table foo and insert sample data
		$db->query("BEGIN;
				CREATE TABLE IF NOT EXISTS short_urls(id INTEGER PRIMARY KEY AUTOINCRIMENT, long_url CHAR(255), short_url CHAR(100), date_created DATETIME);
				INSERT INTO short_urls (long_url, short_url, date_created) VALUES('http://example.com/long','http://example.com/short', '2009-10-20 00:00:00');
				COMMIT;");

		// execute a query
		$result = $db->query("SELECT * FROM short_urls");
		// iterate through the retrieved rows
		while ($result->valid()) {
			// fetch current row
			$row = $result->current();
			print_r($row);
		// proceed to next row
			$result->next();
		}

		// not generally needed as PHP will destroy the connection
		unset($db);
	}


	public static function setupDbPdoSqlite()
	{
		require_once 'MyDb.php';
		$dbh = new MyDb;

		// create
		$create_sql = 'CREATE TABLE IF NOT EXISTS short_urls (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			long_url CHAR(255),
			short_url CHAR(100),
			date_created DATETIME CURRENT_TIMESTAMP
		);';
		$dbh->query($create_sql);

		// populate
		// var_dump(date('Y-m-d H:i:s'));die;
		$insert_sql = sprintf("INSERT INTO short_urls (long_url, short_url, date_created) 
			VALUES('http://example.com/long','http://example.com/short', %s); ", $dbh->quote(date('Y-m-d H:i:s')) );
		$dbh->query($insert_sql);

		// test
		$select_sql = 'SELECT * FROM short_urls';
		$result = $dbh->query($select_sql);
		var_dump($result->fetchAll());

		$dbh = null;
	}


	public function insertData()
	{
		# code...
	}
	
	public static function dumpData()
	{
		require_once 'MyDb.php';
		$dbh = new MyDb;
		$sql = 'SELECT * FROM short_urls;' ;
		$result = $dbh->query($sql);
		var_dump($result->fetchAll());
	}

} // END: ShortUrlUtils{}

?>
