<?php
class databaseConnection{
	public function __construct(){

	}
	//Connect to the database
	static function _getConnection() {
		static $hDB;
		if(isset($hDB)){
			return $hDB;
		}
		//error_reporting(E_USER_ERROR); 
		//$hDB = mysql_connect('eopiatesmasterdb.db.11054938.hostedresource.com', 'eopiatesmasterdb', 'Anthony845!@#');
		$hDB = mysql_connect('localhost', 
						'OLDBMaster', 
						'Lolo455!@#') or die("Failure connecting to the database!");
		mysql_select_db('opiates_list',$hDB)  or die ("Could not open database");
   		return $hDB;
	}
}
?>