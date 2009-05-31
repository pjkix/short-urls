#!/usr/bin/php
<?php

// Ya ... not really a unit test, but hey its a test ;)


ini_set('display_errors', true);

require_once 'memcache.class.php';
cacheMemcache::connect( array( array('localhost' => 11211) ) ); // normally this is done in the configs

print "Starting test!\n";

for ($i = 0; $i < 100; $i++) {
	$key = 'testkey-' . $i;
	cacheMemcache::set($key, $i, 400);
	$result = cacheMemcache::get($key);
	if ($result === false) {
		print 'Got false: ' . $key;
	} else if ($result != $i) {
		print 'Got different result: ' . $key . ' => ' . $result;
	} else {
		print "Ok: $result\n";
	}
}

print "Ending test!\n";

?>
