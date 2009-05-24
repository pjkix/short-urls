<?php

// mysqli vs pdo?

/**
 * PDO Wrapper
 *
 */
class MyDb extends PDO
{
	public function __construct($file = 'MyDb.ini')
	{
		if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

		$dns = $settings['database']['driver'] .
		':host=' . $settings['database']['host'] .
		((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
		';dbname=' . $settings['database']['schema'];

		parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
		
		if ($settings['database']['debug'])
			self::setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // debug silent/warning/exception
	}

	// make this singleton and shit 

} // END: MyDb{}




/**
 * undocumented 
 *
 */
function mysql_insert_array ($my_table, $my_array) {
    $keys = array_keys($my_array);
    $values = array_values($my_array);
    $sql = 'INSERT INTO ' . $my_table . '(' . implode(',', $keys) . ') VALUES ("' . implode('","', $values) . '")';
    return(mysql_query($sql));
}



/**
 * Quote variable to make safe
 *
 * best practice query from http://us2.php.net/manual/en/function.mysql-real-escape-string.php
 *
 * @param unknown_type $value
 * @return unknown
 */
function PK_quote_smart($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not integer
   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value) . "'";
   }
   return $value;
}

?>