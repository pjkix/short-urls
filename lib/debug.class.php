<?php
/**
 * Utilities for Debugging
 *
 * Debug Utils
 * @package		Utils
 * @subpackage	Debug
 * @author		pkhalil
 * @copyright	2009 pjk
 * @license		(cc) some rights reserved
 * @version		$Id:$
 * @todo 		add more features
 */

//* debug and coding pain threshold ;)
ini_set('display_errors',true);
error_reporting(E_ALL | E_STRICT);
//*/

/**
 * setup include paths.
 */
//define('ABS_PATH', realpath('.') ) ; // <-- you are here
//ini_set('include_path', ini_get('include_path').':' . ABS_PATH . '/lib');


/**
 * class for testing memory usage and timing as well as other inspections
 *
 */
class Debug
{
	function __construct ()
	{
		//TODO - Insert your code here
	}

	function get_mem_limit() {
		echo 'MEM LIMIT:' . ini_get('memory_limit') . PHP_EOL;
	}

	function get_mem_usage(){
//		echo 'MEM: ' . memory_get_usage() / 1024 / 1024 .'MB' .  PHP_EOL;
		printf('MEM: %01.2f MB' . PHP_EOL , memory_get_usage() / 1024 /1024);
	}

	function get_mem_peak(){
//		echo 'PEAK MEM: ' . memory_get_peak_usage() / 1024 / 1024 .'MB' . PHP_EOL;
		printf('PEAK MEM: %01.2f MB' . PHP_EOL , memory_get_peak_usage() / 1024 /1024);
	}

	function get_real_mem_peak(){
		echo 'REAL PEAK MEM: ' . memory_get_peak_usage(true) / 1024 / 1024 .'MB' . PHP_EOL;
	}

	function get_real_mem_usage(){
		echo 'REAL MEM: ' . memory_get_usage(true) / 1024 / 1024 .'MB' .  PHP_EOL;
	}

	function get_ps_mem(){
		$output = null;
		$pid = getmypid();
		exec("ps -o rss -p $pid", $output);
		return $output[1] * 1024 ;
	}

	function check_all_mem() {
		$this->get_mem_usage();
		$this->get_mem_peak();
		$this->get_real_mem_usage();
		$this->get_real_mem_peak();
//		echo 'PS MEM: ' . $this->get_ps_mem();
//		echo 'PS MEM ALT: ' . $this->get_ps_mem_alt();
//		$this->log_mem();
	}

	function get_ps_mem_alt() {
		//This should work on most UNIX systems
		$output = null;
		$pid = getmypid();
		exec("ps -eo%mem,rss,pid | grep $pid", $output);
		$output = explode("  ", $output[0]);
		//rss is given in 1024 byte units
		return $output[1] * 1024;
	}

	//$memEstimate = array_size($GLOBALS);
	function array_size($arr) {
		ob_start();
		print_r($arr);
		$mem = ob_get_contents();
		ob_end_clean();
		$mem = preg_replace("/\n +/", "", $mem);
		$mem = strlen($mem);
		return $mem;
	}

	function log_mem() {
		$pid = getmypid();
		error_log('MEMORY USAGE (% KB PID ): ' . `ps --pid $pid --no-headers -o%mem,rss,pid`);
	}

	//return array of variables in global namespace, not including ones pre-defined by php
	function get_user_globals()
	{
		return array_diff_key($GLOBALS, array_flip(array('_GET', '_POST', '_COOKIE',
		'_REQUEST', '_SERVER', '_SESSION', '_FILES', 'argv', 'GLOBALS')));
	}

	function dump_user_globals() {
		$user_globs = $this->get_user_globals();
		echo 'USER GLOBALS: ' . count($user_globs);
		foreach ($user_globs as $glob => $val) {
			echo ' , ' . $glob ;
		}
		var_dump( $user_globs );
	}

	function dump_includes(){
		$incs = get_included_files();
		echo '# of INC:' . count($incs);
		var_dump($incs);
	}

	function xdebug_info () {
		echo xdebug_get_profiler_filename();
	}

} // end: debug{}

/**
* timer class
*/
class Timer extends Debug
{

	function __construct()
	{
		# code ...
	}
}

?>
