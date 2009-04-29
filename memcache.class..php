<?php

/**
 * Memcache Wrapper
 * 
 * @author      Kevin Ostrowski <kevin@podshow.com>
 * @author      John Nishinaga <j.nishinaga@podshow.com>
 * @author      Joseph Engo <jengo@podshow.com>
 * @version     $Id$
 * @copyright   2007 Podshow, Inc.
 *
 */

class Ps_Memcache
{
	static $prefix;
	static $memcache           = NULL;		// Memcache handle
	static $cached             = array();	// Don't hit memcache if we already have the results
	private static $instance   = NULL;
	private static $thin_mode  = False;		// Skips self::$cached if true.  FOR CRON JOBS ONLY.
	const default_ttl          = 86400;		// 24 hours
	const persistent           = False;
	const retry_interval       = 1;
	static $debug_counters     = array
	(
		'get'       => 0,
		'set'       => 0,
		'add'       => 0,
		'delete'    => 0,
		'replace'   => 0,
		'increment' => 0,
		'decrement' => 0,
		'append'    => 0,
		'flush'     => 0
	);

	static $internal_counters   = array		// Used for debugging, counts duplicate requests
	(
		'hit'       => 0,
		'miss'      => 0,
	);

	private function __construct() { }

	function __destruct()
	{
		self::$memcache->close();
	}

	/**
	 * Establish connection with memcache
	 * @param array $user_pool Associated array of memcache addresses to port numbers
	 * @param string $user_prefix Prefix to prepend to all memcache key names utilized by this instance of Ps_Memcache
	 * @return null.
	 */
	static function connect( $user_pool = false, $user_prefix = false )
	{
		self::$memcache = new Memcache;

		// The Ps_Config class not existing should throw fatal for us making the coder go to this line.
		// Coder, if you are reading this, pass your array of memcache servers when using Ps_Memcache::connect() :)
		$servers = is_array($user_pool) ? $user_pool : Ps_Config::get('memcache_servers');

		foreach ((array)$servers as $memcache_server)
		{
			$connect_result =  self::$memcache->addserver(key($memcache_server),$memcache_server[key($memcache_server)],self::persistent,1,self::retry_interval,True);

			if (! $connect_result)
			{
				trigger_error(sprintf('memcache::addserver() failed (%s:%s)',key($memcache_server),$memcache_server[key($memcache_server)]),E_USER_ERROR);
			}
		}
		
		if (is_string($user_prefix) || is_numeric($user_prefix))
		{
			self::$prefix =  $user_prefix;
		}
		else if (class_exists('Ps_Config') && (Ps_Config::get('memcache_use_prefix', false)))
		{
			self::$prefix = Pdn_Url::productToDomain('us') . '_';
		} 
	}

	// Not really needed
	static function singleton()
	{
		if (self::$instance === NULL)
		{
			self::$instance = new self;
		}

		return self::$instance;
	}

	// Presently, its not worth the overhead to use internal cache for multi gets
	private static function get_array($keys)
	{
		self::$debug_counters['get']++;

		$prefixed_keys = array();
		$final_result  = array();

		// Prefix each key
		foreach ((array)$keys as $key)
		{
			$prefixed_keys[] = self::$prefix . $key;
		}

		$memcache_results = self::$memcache->get($prefixed_keys);

		// Strip prefix off results
		foreach ((array)$memcache_results as $memcache_result_key => $memcache_result_value)
		{
			$final_result[str_replace(self::$prefix,'',$memcache_result_key)] = $memcache_result_value;
		}

		return $final_result;
	}

	/**
	 * Sets self::$thin_mode.  If self::$thin_mode is true, calls to
	 * get() will not check or store results in a local instance
	 * variable.  This is primarily for use with long-running cron
	 * jobs that instantiate many objects and would otherwise max out memory.
	 */

	public static function setThinMode($mode=true) {
		self::$thin_mode = ($mode === true || $mode === false) ? $mode : false;
	}

	/**
	 * Returns the value stored in the memory by it's key
	 *
	 * @param mix $key
	 * @return mix
	 */
	static function get($key)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::get() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		if (is_array($key))
		{
			return self::get_array($key);
		}
		$key = self::$prefix . $key;

		if (self::$thin_mode) return self::$memcache->get($key);

		if (! array_key_exists($key,self::$cached))
		{
			self::$internal_counters['miss']++;

			self::$cached[$key] = self::$memcache->get($key);
		}
		else
		{
			self::$internal_counters['hit']++;
		}

		self::$debug_counters['get']++;

		return self::$cached[$key];
	}

	/**
	 * Store the value in the memcache memory (overwrite if key exists)
	 *
	 * @param string $key
	 * @param mix $value
	 * @param bool $compress
	 * @param int $ttl (seconds before item expires)
	 * @return bool
	 */
	static function set($key,$value,$compress = False, $ttl = NULL)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::set() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		if ($ttl === NULL)
		{
			$ttl = self::default_ttl;
		}

		self::$cached[$key] = $value;

		self::$debug_counters['set']++;

		return self::$memcache->set($key,$value,($compress ? MEMCACHE_COMPRESSED : NULL),$ttl);
	}

	/**
	 * Replace an existing value
	 *
	 * @param string $key
	 * @param mix $value
	 * @param bool $compress
	 * @param int $ttl
	 * @return bool
	 */
	static function replace($key,$value,$compress = False, $ttl = NULL)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::replace() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		if ($ttl === NULL)
		{
			$ttl = self::default_ttl;
		}

		self::$cached[$key] = $value;

		self::$debug_counters['replace']++;

		return self::$memcache->replace($key,$value,($compress ? MEMCACHE_COMPRESSED : NULL),$ttl);
	}

	/**
	 * Set the value in memcache if the value does not exist; returns FALSE if value exists
	 *
	 * @param sting $key
	 * @param mix $value
	 * @param bool $compress
	 * @param int $ttl
	 * @return bool
	 */
	static function add($key,$value,$compress = False, $ttl = NULL)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::add() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		if ($ttl === NULL)
		{
			$ttl = self::default_ttl;
		}

		$result = self::$memcache->add($key,$value,($compress ? MEMCACHE_COMPRESSED : NULL),$ttl);
		if ($result !== NULL)
		{
			self::$cached[$key] = $value;
		}

		self::$debug_counters['add']++;

		return $result;
	}

	/**
	 * Delete a record or set a timeout - Don't use $seconds_till_delete unless you know what you are doing
	 *
	 * @param string $key
	 * @param int $seconds_till_delete
	 * @return bool
	 */
	static function delete($key,$seconds_till_delete = NULL)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::delete() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		$result = self::$memcache->delete($key,$seconds_till_delete);
		if ($result !== NULL)
		{
			unset(self::$cached[$key]);
		}

		self::$debug_counters['delete']++;

		return $result;
	}

	/**
	 * Increment an existing integer value
	 *
	 * @param string $key
	 * @param int $value
	 * @return bool
	 */
	static function increment($key,$value = 1)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::increment() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		self::$debug_counters['increment']++;

		// Don't calculate it here, allow memcache to increment and tell us its real value
		self::$cached[$key] = self::$memcache->increment($key,$value);

		return self::$cached[$key];
	}

	/**
	 * Decrement an existing value
	 *
	 * @param string $key
	 * @param int $value
	 * @return bool
	 */
	static function decrement($key,$value = 1)
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::decrement() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		$key = self::$prefix . $key;

		self::$debug_counters['decrement']++;

		// Don't calculate it here, allow memcache to decrement and tell us its real value
		self::$cached[$key] = self::$memcache->decrement($key,$value);

		return self::$cached[$key];
	}

	// Production memcache doesn't support this yet - 04/11/2008 (jengo)
	static function append($key,$value)
	{
		/*
		$key = self::$prefix . $key;

		self::$debug_counters['append']++;

		//self::$cached[$key] .= $value;

		return self::$memcache->append($key,$value);
		*/

		return False;
	}

	/**
	 * Clear the cache - This should never be called in production
	 *
	 * @return void
	 */
	static function flush()
	{
		if (self::$memcache === NULL)
		{
			trigger_error('Ps_Memcache::flush() attempted with no connection present',E_USER_ERROR);

			return False;
		}

		// We don't clear out self::$cached to discourage using it for anything except debugging
		return self::$memcache->flush();
	}

}

