<?php

defined('LIB_PATH')
	|| define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));
	
	// set lib path
	set_include_path(implode(PATH_SEPARATOR, array(
		LIB_PATH,
		get_include_path(),
	)));
	
?>