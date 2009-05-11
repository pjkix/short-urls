<?php
// set lib path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(dirname(__FILE__) . '/../lib'),
	get_include_path(),
)));

defined('LIB_PATH')
	|| define('LIB_PATH', realpath(dirname(__FILE__) . '/../lib'));
?>