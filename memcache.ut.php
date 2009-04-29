#!/pkg/bin/php
<?php

ini_set('display_errors', true);

require_once '/app/podshow.com/current/htdocs/includes/lib_inc.php';

print "Starting test!\n";
for ($i = 0; $i < 100; $i++) {
	$key = 'testkey-' . $i;
	Ps_Memcache::set($key, $i, 400);
	$result = Ps_Memcache::get($key);
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
