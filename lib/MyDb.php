<?php

/**
 * PDO Wrapper
 *
 */
class MyDb extends PDO
{
	public function __construct($file = 'Db.ini')
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


	function mysql_insert_array ($my_table, $my_array) {
	    $keys = array_keys($my_array);
	    $values = array_values($my_array);
	    $sql = 'INSERT INTO ' . $my_table . '(' . implode(',', $keys) . ') VALUES ("' . implode('","', $values) . '")';
	    return(mysql_query($sql));
	}
}


class PDOConfig extends PDO {
   
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
   
    public function __construct(){
        $this->engine = 'mysql';
        $this->host = 'localhost';
        $this->database = '';
        $this->user = 'root';
        $this->pass = '';
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass );
    }
}


// mysqli vs pdo?


?>