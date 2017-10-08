<?php
abstract class abstractDatabase{
	private $db;
	
	abstract public function __construct($host, $username, $password, $databaseName);
	abstract public function __destruct();
	abstract public function select($query);
	abstract public function query();
}
?>
